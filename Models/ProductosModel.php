<?php
    class ProductosModel extends Mysql
    {
        public $intIdproducto;
        public $strCategoria;
        public $intCodigo;
        public $strProducto;
		public $floatPrecioCompra;
		public $floatPrecioVenta;
        public $intStock;
		public $strDescripcion;
        public $strImagen;
		public $intStatus;

        public function __construct(){
            parent::__construct();
        }
		public function selectProducto(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "SELECT p.idproducto,p.codigo,p.nombre,p.precio_compra,p.precio_venta,p.stock,p.descripcion,p.portada,p.categoriaid,c.nombre as categoria,
            p.status FROM producto p INNER JOIN categoria c ON p.categoriaid = c.idcategoria
            WHERE idproducto = $this->intIdProducto";
			$request = $this->select($sql);
			return $request;

		}
        public function selectProductos(){
            $sql = "SELECT p.idproducto, p.codigo, p.nombre,p.precio_compra,p.precio_venta,p.stock,p.portada,p.categoriaid, c.nombre as categoria, 
            	   p.status FROM producto p INNER JOIN categoria c ON p.categoriaid = c.idcategoria 
                   WHERE p.status != 0";
            $request = $this->select_all($sql);
            return $request;
        }
        public function insertProducto(string $nombre,string $codigo,float $precio_compra,float $precio_venta,int $stock,string $descripcion,int $categoriaid,string $img, int $estado){
			$this->strNombre = $nombre;
			$this->intCodigo = $codigo;
			$this->floatPrecioCompra = $precio_compra;
			$this->floatPrecioVenta = $precio_venta;
			$this->intStock = $stock;
			$this->strDescripcion = $descripcion;
			$this->strCategoria = $categoriaid;
			$this->strImagen = $img;
			$this->intStatus = $estado;
			$return = 0;
			$sql = "SELECT * FROM producto WHERE codigo = '$this->intCodigo' OR nombre='$this->strNombre'";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$query_insert  = "INSERT INTO producto(categoriaid,codigo,nombre,precio_compra,precio_venta,stock,descripcion,portada,status,datecreated) VALUES(?,?,?,?,?,?,?,?,?,?)";
	        	$arrData = array($this->strCategoria,$this->intCodigo,$this->strNombre,$this->floatPrecioCompra,$this->floatPrecioVenta,$this->intStock,$this->strDescripcion,$this->strImagen,$this->intStatus,date('Y-m-d'));
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}
		public function insert_entrada(int $usuario, int $proveedor, float $total){

			$sql = "INSERT INTO entradas(usuarioid,proveedorid,total,status,datecreated,timecreated) VALUES(?,?,?,?,?,?)";
	        $arrData = array($usuario,$proveedor,$total,1,date('Y-m-d'),date('H:i:s'));
	        $request = $this->insert($sql,$arrData);
			if($request){
				$sql = "SELECT MAX(identrada) AS identrada FROM entradas";
				$return = $this->select($sql);
			}
	        return $return;
		}
		public function select_producto(){
			$sql = "SELECT MAX(idproducto) AS idproducto FROM producto";
			$request = $this->select($sql);
            return $request;
        }
		public function insert_detalle_entrada(int $entradaid,int $productoid,int $cantidad,float $precio_compra,int $total){
			$sql = "INSERT INTO detalle_entradas(entradaid,productoid,cantidad,precio,subtotal) VALUES(?,?,?,?,?)";
	        $arrData = array($entradaid,$productoid,$cantidad,$precio_compra,$total);
	        $request = $this->insert($sql,$arrData);
	        return $request;
		}
		public function insertMovimientos(String $strNombre,int $intStock){
			$this->strNombre = $strNombre;
			$this->intStock = $intStock;
		
			$sql = "INSERT INTO movimientos(fecha,producto,iven_inicial,entradas,salidas,existencias) VALUES(?,?,?,?,?,?)";
	        $arrData = array(date('Y-m-d'),$this->strNombre,$this->intStock,$this->intStock,0,$this->intStock);
	        $request = $this->insert($sql,$arrData);
			if($request){
				$sql = "SELECT MAX(idmovimiento) AS idmovimiento FROM movimientos";
				$return = $this->select($sql);
			}
	        return $return;
		}
		public function insert_detalle_movimiento(int $id_movimiento,int $intStock,float $precio_compra){
			$total = $intStock * $precio_compra;
			$sql = "INSERT INTO detalle_movimientos(movimientoid,tipo_movimiento,descripcion,cantidad,precio,total,datecreated) VALUES(?,?,?,?,?,?,?)";
	        $arrData = array($id_movimiento,1,"Compra de producto (Mediante registro)",$intStock,$precio_compra,$total,date('Y-m-d'));
	        $request = $this->insert($sql,$arrData);
	        return $request;
		}

		public function updateProducto(int $idproducto,string $nombre,string $codigo,float $precio_compra,float $precio_venta,int $stock,string $descripcion,int $categoriaid,string $img,int $estado){
			$this->intIdProducto = $idproducto;
			$this->strNombre = $nombre;
			$this->intCodigo = $codigo;
			$this->floatPrecioCompra = $precio_compra;
			$this->floatPrecioVenta = $precio_venta;
			$this->intStock = $stock;
			$this->strDescripcion = $descripcion;
			$this->strCategoria = $categoriaid;
			$this->strImagen = $img;
			$this->intStatus = $estado;
			$return = 0;
			$sql = "SELECT * FROM producto WHERE codigo = '$this->intCodigo' AND idproducto != $this->intIdProducto";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE producto SET categoriaid=?,codigo=?,nombre=?,precio_compra=?,precio_venta=?,stock=?,descripcion=?,portada=?,status=?
						WHERE idproducto = $this->intIdProducto";
				$arrData = $arrData = array($this->strCategoria,$this->intCodigo,$this->strNombre,$this->floatPrecioCompra,$this->floatPrecioVenta,$this->intStock,$this->strDescripcion,$this->strImagen,$this->intStatus);
	        	$request = $this->update($sql,$arrData);
	        	$return = $request;
			}else{
				$return = "exist";
			}
	        return $return;
		}
		public function deleteProducto(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "UPDATE producto SET status = ? WHERE idproducto = $this->intIdProducto ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			// if($request){
			// 	$sql = "UPDATE producto SET status = ? WHERE idproducto = $this->intIdProducto ";
			// 	$arrData = array(0);
			// 	$request = $this->update($sql,$arrData);
			// }
			return $request;
		}
    }
?>