<?php
	class configuracionModel extends Mysql
	{	
		private $intIdempresa; 
		private $strRucBusiness;
		private $strNombreBusiness;
		private $strDireccionBusiness;
		private $strTelefonoBusiness;
		private $strEmailBusiness;

		public function __construct()
		{
			parent::__construct();
		}

		public function configuracion()
		{
			$sql = "SELECT * FROM company";
			$request = $this->select($sql);
			$_SESSION['dataCompany'] = $request;
			return $request;
		}

		public function updateBusiness(int $idempresa,string $ruc,string $nombre,string $direccion,string $telefono,string $email){
			$this->intIdempresa = $idempresa;
			$this->strRucBusiness = $ruc;
			$this->strNombreBusiness = $nombre;
			$this->strDireccionBusiness = $direccion;
			$this->strTelefonoBusiness = $telefono;
			$this->strEmailBusiness = $email;
			$sql = "UPDATE config SET ruc=?, nombre=?, direccion=?,telefono=?,correo=? WHERE idempresa = $this->intIdempresa";
			$arrData = array($this->strRucBusiness,$this->strNombreBusiness,$this->strDireccionBusiness,$this->strTelefonoBusiness,$this->strEmailBusiness);
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}
?>