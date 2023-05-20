<?php
	class UsuariosModel extends Mysql
	{
		private $intIdUsuario;
		private $strUsername;
		private $strNombre;
        private $strEmail;
        private $strPassword;
        private $intTipoId;
        private $intStatus;

		public function __construct()
		{
            parent::__construct();
		}
        public function insertUsuario(string $username,string $nombre,string $email, string $password, int $tipoid, int $status)
        {
			$this->strUsername = $username;
			$this->strNombre = $nombre;
            $this->strEmail = $email;
            $this->strPassword = $password;
            $this->intTipoId = $tipoid;
            $this->intStatus = $status;
            $return = 0;
            $sql = "SELECT * FROM usuario WHERE email = '{$this->strEmail}'";
            $request = $this->select_all($sql);
            if(empty($request)){
                $sql_insert = "INSERT INTO usuario(username,nombre,email,password,rolid,status) VALUES (?,?,?,?,?,?)";
                $arrData = array($this->strUsername,
							   $this->strNombre,
                               $this->strEmail,
                               $this->strPassword,
                               $this->intTipoId,
                               $this->intStatus
                              );
                $request_insert = $this->insert($sql_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function selectUsuarios()
        {
			$whereAdmin = "";
			if($_SESSION['id_usuario'] !=1){
				$whereAdmin = " AND u.idusuario !=1";
			}
            $sql = "SELECT u.idusuario,u.username,u.nombre,u.email,u.status,r.idrol,r.rol FROM usuario u INNER JOIN rol r ON u.rolid = r.idrol WHERE u.status !=0 ".$whereAdmin;
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectUsuario(int $idusuario)
        {
            $this->intIdUsuario = $idusuario;
			$sql = "SELECT u.idusuario,u.username,u.nombre,u.email,r.idrol,r.rol,u.status 
					FROM usuario u INNER JOIN rol r ON u.rolid = r.idrol
					WHERE u.idusuario = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
        }

        public function updateUsuario(int $idUsuario,string $username,string $nombre, string $email, string $password, int $tipoid, int $status){

			$this->intIdUsuario = $idUsuario;
			$this->strUsername = $username;
			$this->strNombre = $nombre;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;

			$sql = "SELECT * FROM usuario WHERE email = '$this->strEmail' AND idusuario != $this->intIdUsuario";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				if($this->strPassword  != "")
				{
					if($this->intIdUsuario==1){
						$sql = "UPDATE usuario SET nombre=?, email=?, password=?
						WHERE idusuario = $this->intIdUsuario ";
						$arrData = array($this->strNombre,$this->strEmail,$this->strPassword);
					}else{
						$sql = "UPDATE usuario SET username=?,nombre=?, email=?, password=?, rolid=?, status=? 
						WHERE idusuario = $this->intIdUsuario ";
						$arrData = array($this->strUsername,$this->strNombre,$this->strEmail,$this->strPassword,$this->intTipoId,$this->intStatus);
					}
				}else{
					if($this->intIdUsuario==1){
						$sql = "UPDATE usuario SET nombre=?, email=?
							WHERE idusuario = $this->intIdUsuario ";
						$arrData = array($this->strNombre,$this->strEmail);
					}else{
						$sql = "UPDATE usuario SET username=?,nombre=?, email=?, rolid=?, status=? 
							WHERE idusuario = $this->intIdUsuario ";
						$arrData = array($this->strUsername,$this->strNombre,$this->strEmail,$this->intTipoId,$this->intStatus);
					}
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}
        
        public function deleteUsuario(int $intIdpersona)
		{
			$this->intIdUsuario = $intIdpersona;
			$sql = "UPDATE usuario SET status = ? WHERE idusuario = $this->intIdUsuario ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}
		public function updatePerfil(int $idUsuario, string $username, string $nombre, string $password){
			$this->intIdUsuario = $idUsuario;
			$this->strUsername = $username;
			$this->strNombre = $nombre;
			$this->strPassword = $password;

			if($this->strPassword != "")
			{
				$sql = "UPDATE usuario SET username=?, nombre=?, password=? 
						WHERE idusuario = $this->intIdUsuario";
				$arrData = array($this->strUsername,$this->strNombre,$this->strPassword);
			}else{
				$sql = "UPDATE usuario SET username=?, nombre=?
						WHERE idusuario = $this->intIdUsuario";
				$arrData = array($this->strUsername,
								$this->strNombre);
			}
			$request = $this->update($sql,$arrData);
		    return $request;
		}
	}
?>