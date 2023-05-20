<?php
	class homeModel extends Mysql
	{
		private $intIdUsuario;
		private	$strUsuario;
		private $strPassword;
		private $strToken;
		 
		public function __construct()
		{
			parent::__construct();
		}

		public function loginUser(string $usuario, string $password)
		{
			$this->strUsuario = $usuario;
			$this->strPassword = $password;

			$sql = "SELECT idusuario,status FROM usuario 
			       WHERE email = '$this->strUsuario' and 
				   password = '$this->strPassword' and status !=0";
			$request = $this->select($sql);
			return $request;
		}

		public function sessionLogin(int $iduser)
		{
			$this->intIdUsuario = $iduser;
			$sql = "SELECT u.idusuario,u.username,u.nombre,u.email,r.idrol,r.rol,u.status 
			FROM usuario u INNER JOIN rol r ON u.rolid = r.idrol WHERE u.idusuario = $this->intIdUsuario";
			$request = $this->select($sql);
			$_SESSION['userData'] = $request;
			return $request;
		}
	}
?>