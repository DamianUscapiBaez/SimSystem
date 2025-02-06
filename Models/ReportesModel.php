<?php
	class reportesModel extends Mysql
	{	 
		public function __construct()
		{
			parent::__construct();
		}
		public function getStockMinimo(){
			$sql = "SELECT * FROM producto WHERE stock <= 5 ORDER BY idproducto DESC";
			$request = $this->select_all($sql);
			return $request;
		}

		public function select_date_entradas(string $date_from,string $date_to){
            $sql = "SELECT e.*,u.*,p.idproveedor,p.nombre as proveedor FROM entradas e INNER JOIN usuario u ON e.usuarioid = u.idusuario 
			INNER JOIN proveedor p ON e.proveedorid = p.idproveedor 
			WHERE e.datecreated BETWEEN '$date_from' AND '$date_to' AND e.status!=0";
            $request = $this->select_all($sql);
            return $request;
        }
		public function select_date_salidas(string $date_from,string $date_to){
            $sql = "SELECT s.*,u.*,c.idcliente,c.nombre as cliente FROM salidas s INNER JOIN usuario u ON s.usuarioid = u.idusuario
			INNER JOIN cliente c ON s.clienteid = c.idcliente  
			WHERE s.datecreated BETWEEN '$date_from' AND '$date_to' AND s.status!=0";
            $request = $this->select_all($sql);
            return $request;
        }
		public function selectKardex(){
			$sql = "SELECT idmovimiento,producto,DATE_FORMAT(fecha,'%m-%Y') AS	fecha,iven_inicial,existencias,entradas,salidas
			FROM movimientos";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectKardexProducto(int $idmovimiento){
			$sql = "SELECT * FROM detalle_movimientos WHERE movimientoid = $idmovimiento";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectMovimiento(int $idmovimiento){
			$sql = "SELECT producto,DATE_FORMAT(fecha,'%m-%Y') AS fecha,iven_inicial,existencias,entradas,salidas FROM movimientos WHERE idmovimiento = $idmovimiento";
			$request = $this->select($sql);
			return $request;
		}

		public function precio_entradas(int $idmovimiento){
			$sql = "SELECT SUM(total) AS total_entradas FROM detalle_movimientos WHERE movimientoid = $idmovimiento AND tipo_movimiento = 1";
			$request = $this->select($sql);
			return $request;
		}
		public function precio_salidas(int $idmovimiento){
			$sql = "SELECT SUM(total) AS total_salidas FROM detalle_movimientos WHERE movimientoid = $idmovimiento AND tipo_movimiento = 2";
			$request = $this->select($sql);
			return $request;
		}
	}
?>