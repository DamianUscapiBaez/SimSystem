<?php
    class SalidasModel extends Mysql
    {
        public $intIdsalida;
        public $intIdproducto;
        public $intIdusuario;
        public $Cantidad;
		public $strDescripcion;

        public function __construct(){
            parent::__construct();
        }

        public function obtenerSerie(int $tipo_documento){
            $sql = "SELECT MAX(serie_documento) AS serie FROM salidas WHERE tipo_documento = $tipo_documento";
            $request = $this->select($sql);
            if(!isset($request)){
                $return = "";
            }else{
                $return = $request;
            }
            return $return;
        }

        public function get_tmp_detalle($idusuario){
            $sql = "SELECT d.*, p.idproducto,p.codigo as codigo,p.nombre as producto FROM dtmp_salida d INNER JOIN producto p ON
            d.productoid = p.idproducto WHERE d.usuarioid = $idusuario";
            $request = $this->select_all($sql);
            return $request;
        }

        public function getProducto(int $id){
            $sql = "SELECT * FROM producto WHERE idproducto = $id";
            $request = $this->select($sql);
            return $request;
        }

        public function consultarDetalle(int $idproducto, int $idusuario){
            $sql = "SELECT * FROM dtmp_salida WHERE productoid = $idproducto AND usuarioid = $idusuario";
            $request = $this->select($sql);
            return $request;
        }

        public function registrarDetalle(int $idproducto,int $idusuario,int $cantidad,float $precio,float $subtotal){
            $sql = "INSERT INTO dtmp_salida (productoid,usuarioid,cantidad,precio,subtotal) VALUES (?,?,?,?,?)";
            $arrData = array($idproducto,$idusuario,$cantidad,$precio,$subtotal);
            $request = $this->insert($sql,$arrData);
            if(isset($request)){
                $return = "ok";
            }else{
                $return = "error";
            }
            return $return;
        }

        public function actualizarDetalle(int $idproducto,int $idusuario,int $total_cantidad,float $subtotal){
            $sql = "UPDATE dtmp_salida SET cantidad=?,subtotal=? WHERE productoid = ? AND usuarioid = ?";
            $arrData = array($total_cantidad,$subtotal,$idproducto,$idusuario);
            $request = $this->insert($sql,$arrData);
            if(isset($request)){
                $return = "ok";
            }else{
                $return = "error";
            }
            return $return;
        }
        
		public function registrarSalida(int $idusuario,int $idcliente,float $total){
            $this->intIdusuario = $idusuario;
            $sql = "INSERT INTO salidas(usuarioid,clienteid,total,datecreated,timecreated) VALUES (?,?,?,?,?)";
            $arrData = array($this->intIdusuario,$idcliente,$total,date('Y-m-d'),date('H:i:s'));
            $request = $this->insert($sql,$arrData);
            if(isset($request)){
                $return = "ok";
            }else{
                $return = "error";
            }
            return $return;
        }

        public function seleccionarProducto(int $idproducto){
            $sql = "SELECT * FROM producto WHERE idproducto = $idproducto";
			$request = $this->select($sql);
            return $request;
        }
        public function registrarMovimientos(string $producto,int $stock,int $cantidad){
			$sql = "SELECT * FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
			$request = $this->select_all($sql);
			if(empty($request))
			{
                $sql = "INSERT INTO movimientos(fecha,producto,iven_inicial,entradas,salidas,existencias) VALUES(?,?,?,?,?,?)";
                $arrData = array(date('Y-m-d'),$producto,$stock,0,$cantidad,$stock);
                $request_m = $this->insert($sql,$arrData);
			}else{
                $sql = "SELECT salidas FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
                $request = $this->select($sql);
                if($request){
                    $cantidadT = $request['salidas'] + $cantidad;
                    $sql = "UPDATE movimientos SET salidas = ?,existencias = ?  WHERE producto = ?";
                    $arrData = array($cantidadT,$stock,$producto);
                    $request_m = $this->insert($sql,$arrData);
                }
			}
            if($request_m >= 0){
                $sql = "SELECT * FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
			    $sql_resquest = $this->select_all($sql);
                return $sql_resquest;
            }
        }
        public function detalle_movimiento(int $id_movimiento,int $cantidad,float $precio,float $subtotal){
			$sql = "INSERT INTO detalle_movimientos(movimientoid,tipo_movimiento,descripcion,cantidad,precio,total,datecreated) VALUES(?,?,?,?,?,?,?)";
	        $arrData = array($id_movimiento,2,"Venta de producto",$cantidad,$precio,$subtotal,date('Y-m-d'));
	        $request = $this->insert($sql,$arrData);
	        return $request;
		}

        public function set_movimiento(string $producto,int $stock,int $cantidad){
            $sql = "SELECT * FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
			$request = $this->select_all($sql);
			if(empty($request))
			{
                $sql = "INSERT INTO movimientos(fecha,producto,iven_inicial,entradas,salidas,existencias) VALUES(?,?,?,?,?,?)";
                $arrData = array(date('Y-m-d'),$producto,$stock,$cantidad,0,$stock);
                $request_m = $this->insert($sql,$arrData);
			}else{
                $sql = "SELECT entradas FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
                $request = $this->select($sql);
                if($request){
                    $cantidadT = $request['entradas'] + $cantidad;
                    $sql = "UPDATE movimientos SET entradas = ?,existencias = ?  WHERE producto = ?";
                    $arrData = array($cantidadT,$stock,$producto);
                    $request_m = $this->insert($sql,$arrData);
                }
			}
            if($request_m >= 0){
                $sql = "SELECT * FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
			    $sql_resquest = $this->select_all($sql);
                return $sql_resquest;
            }
        }
        public function set_detalle_movimiento(int $id_movimiento,int $cantidad,float $precio,float $subtotal){
			$sql = "INSERT INTO detalle_movimientos(movimientoid,tipo_movimiento,descripcion,cantidad,precio,total,datecreated) VALUES(?,?,?,?,?,?,?)";
	        $arrData = array($id_movimiento,1,"Entrada por anulacion",$cantidad,$precio,$subtotal,date('Y-m-d'));
	        $request = $this->insert($sql,$arrData);
	        return $request;
		}
        public function id_salida(){
            $sql = "SELECT MAX(idsalida) AS idsalida FROM salidas";
            $resquest = $this->select($sql);
            return $resquest;
        }
        
        public function registrar_detalle_salida(int $idsalida, int $idproducto, int $cantidad,float $precio,float $subtotal){
            $this->intIdsalida = $idsalida;
            $this->intIdproducto = $idproducto;
            $this->Cantidad = $cantidad;
            $sql = "INSERT INTO detalle_salidas(salidaid,productoid,cantidad,precio,subtotal) VALUES (?,?,?,?,?)";
            $arrData = array($this->intIdsalida,$this->intIdproducto,$this->Cantidad,$precio,$subtotal);
            $request = $this->insert($sql,$arrData);
            if(isset($request)){
                $return = "ok";
            }else{
                $return = "error";
            }
            return $return;
        }
        public function deleteDetalle(int $id_detalle){
            $sql = "DELETE FROM dtmp_salida WHERE dtmp_salida_id = ?";
            $dato = array($id_detalle);
            $request = $this->insert($sql,$dato);
            if(isset($request)){
                $return = "ok";
            }else{
                $return = "error";
            }
            return $return;
        }
        public function actualizarStock(int $idproducto,int $cantidad){
            $sql = "UPDATE producto SET stock = ? WHERE idproducto = ?";
            $arrData = array($cantidad,$idproducto);
            $data = $this->insert($sql,$arrData);
            return $data;
        }

        public function vaciarDetalle(int $idusuario){
            $this->intIdusuario = $idusuario;
            $sql = "DELETE FROM dtmp_salida WHERE usuarioid = ?";
            $arrData = array($this->intIdusuario);
            $request = $this->insert($sql,$arrData);
            if(isset($request)){
                $return = "ok";
            }else{
                $return = "error";
            }
            return $return;
        }
        
        public function getHistorialSalida(){
			$sql = "SELECT s.*,c.nombre as cliente,u.username as usuario FROM salidas s 
            INNER JOIN usuario u ON s.usuarioid = u.idusuario  INNER JOIN cliente c ON s.clienteid = c.idcliente";
			$resquest = $this->select_all($sql);
            return $resquest;
		}

        public function getFacturaSalidahoy(){
			$sql = "SELECT s.*,c.nombre as cliente,u.username as usuario FROM salidas s INNER JOIN usuario u 
            ON s.usuarioid = u.idusuario INNER JOIN cliente c ON s.clienteid = c.idcliente
            WHERE s.tipo_documento = 1 AND s.datecreated >= CURDATE() AND s.status = 1";
			$resquest = $this->select_all($sql);
            return $resquest;
		}

        public function getFacturaSalidahoyAnulados(){
			$sql = "SELECT s.*,c.nombre as cliente,u.username as usuario FROM salidas s INNER JOIN usuario u 
            ON s.usuarioid = u.idusuario INNER JOIN cliente c ON s.clienteid = c.idcliente
            WHERE s.tipo_documento = 1 AND s.datecreated >= CURDATE() AND s.status = 0";
			$resquest = $this->select_all($sql);
            return $resquest;
		}

        public function getBoletashoy(){
            $sql = "SELECT s.*,c.nombre as cliente,u.username as usuario FROM salidas s INNER JOIN usuario u 
            ON s.usuarioid = u.idusuario INNER JOIN cliente c ON s.clienteid = c.idcliente
            WHERE s.tipo_documento = 2 AND s.datecreated >= CURDATE() AND s.status = 1";
			$resquest = $this->select_all($sql);
            return $resquest;
        }
        public function getBoletasAnuladoshoy(){
            $sql = "SELECT s.*,c.nombre as cliente,u.username as usuario FROM salidas s INNER JOIN usuario u 
            ON s.usuarioid = u.idusuario INNER JOIN cliente c ON s.clienteid = c.idcliente
            WHERE s.tipo_documento = 2 AND s.datecreated >= CURDATE() AND s.status = 0";
			$resquest = $this->select_all($sql);
            return $resquest;
        }

        public function getProSalida(int $idsalida){
            $this->intIdsalida = $idsalida;
            $sql = "SELECT s.*,d.*,p.idproducto,p.nombre,p.codigo,p.precio_compra FROM salidas s INNER JOIN detalle_salidas d 
            ON s.idsalida = d.salidaid INNER JOIN producto p ON p.idproducto = d.productoid 
            WHERE s.idsalida = $this->intIdsalida";
            $resquest = $this->select_all($sql);
            return $resquest;
        }

        public function getEmpresa(){
            $sql = "SELECT * FROM config";
            $data = $this->select($sql);
            return $data;
        }

        public function getAnularSalida(int $id_salida){
            $this->intIdsalida = $id_salida;
            $sql = "SELECT s.*,d.* FROM salidas s INNER JOIN detalle_salidas d ON s.idsalida = d.salidaid
                    WHERE s.idsalida = $this->intIdsalida";
            $request = $this->select_all($sql);
            return $request;
        }

		public function getAnular(int $id_salida){
            $this->intIdsalida = $id_salida;
			$sql = "UPDATE salidas SET status = ? WHERE idsalida = ?";
			$arrData = array(0,$this->intIdsalida);
			$request = $this->insert($sql,$arrData);
            if($request == 0){
                $return = "ok";
            }else{
                $return = "error";
            }
			return $return;
		}

        public function getTotalDetalle(int $idusuario){
            $sql = "SELECT subtotal,SUM(subtotal) AS total FROM dtmp_salida WHERE usuarioid = $idusuario";
            $request = $this->select($sql);
            return $request;
        }
        public function getDetalleTmp($idusuario){
            $this->intIdusuario = $idusuario;
            $sql = "SELECT * FROM dtmp_salida WHERE usuarioid = $this->intIdusuario";
            $request = $this->select_all($sql);
            return $request;
        }

        public function getSalida(int $idsalida){
            $sql = "SELECT * FROM salidas WHERE idsalida = $idsalida";
            $resquest = $this->select($sql);
            return $resquest;
        }

        public function getClienteSalida(int $idsalida){
            $sql="SELECT s.*,c.tipo_documento,c.documento,c.nombre as cliente, c.telefono,c.direccion FROM salidas s INNER JOIN cliente c
            ON c.idcliente = s.clienteid 
            WHERE s.idsalida = $idsalida";
            $resquest = $this->select($sql);
            return $resquest;
        }

        public function select_date_salidas(string $date_from,string $date_to){
            $sql = "SELECT s.*,u.*,c.idcliente,c.nombre as cliente FROM salidas s INNER JOIN usuario u ON s.usuarioid = u.idusuario
			INNER JOIN cliente c ON s.clienteid = c.idcliente  
			WHERE s.datecreated BETWEEN '$date_from' AND '$date_to' AND s.status!=0";
            $request = $this->select_all($sql);
            return $request;
        }

        public function getFacturas(){
			$sql = "SELECT COUNT(*) AS total FROM salidas WHERE datecreated >= CURDATE() AND tipo_documento =1 AND status !=0; ";
			$request = $this->select($sql);
			return $request;
		}

        public function getBoletas(){
			$sql = "SELECT COUNT(*) AS total FROM salidas WHERE datecreated >= CURDATE() AND tipo_documento =2 AND status !=0; ";
			$request = $this->select($sql);
			return $request;
		}

        public function getFacturasAnulado(){
			$sql = "SELECT COUNT(*) AS total FROM salidas WHERE datecreated >= CURDATE() AND tipo_documento =1 AND status =0; ";
			$request = $this->select($sql);
			return $request;
		}

        public function getBoletasAnulado(){
			$sql = "SELECT COUNT(*) AS total FROM salidas WHERE datecreated >= CURDATE() AND tipo_documento =2 AND status =0; ";
			$request = $this->select($sql);
			return $request;
		}
    }
?>