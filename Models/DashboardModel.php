<?php
	class dashboardModel extends Mysql
	{	 
		public function __construct()
		{
			parent::__construct();
		}

		public function getDatos(string $table){
			$sql = "SELECT COUNT(*) as total FROM $table WHERE status !=0";
			$request = $this->select($sql);
			return $request;
		}

		public function getStockMinimo(){
			$sql = "SELECT codigo,nombre,stock FROM producto WHERE stock <= 4 ORDER BY idproducto DESC LIMIT 10";
			$request = $this->select_all($sql);
			return $request;
		}
		public function getProductoSalidas(){
			$sql = "SELECT d.productoid,d.cantidad,p.idproducto,p.nombre, SUM(d.cantidad) AS total FROM detalle_salidas d 
			INNER JOIN producto p ON p.idproducto = d.productoid GROUP BY d.productoid 
			ORDER BY d.cantidad DESC LIMIT 10";
			$request = $this->select_all($sql);
			return $request;
		}
		public function getEntradas(){
			$sql = "SELECT COUNT(*) AS total FROM entradas WHERE datecreated >= CURDATE() AND status !=0";
			$request = $this->select($sql);
			return $request;
		}
		public function getSalidas(){
			$sql = "SELECT COUNT(*) AS total FROM salidas WHERE datecreated >= CURDATE() AND status !=0";
			$request = $this->select($sql);
			return $request;
		}
	}
?>