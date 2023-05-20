<?php
	class PermisosModel extends Mysql
	{
        public $intIdpermisos;
        public $intRolid;
        public $intModulos;

		public function __construct()
		{
            parent::__construct();
		}

        public function selectModulos(){
            $sql = "SELECT * FROM modulo WHERE idmodulo!=1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPermisosRol(int $idrol){
            $this->intRolid = $idrol;
            $sql = "SELECT * FROM permisos WHERE rolid = $this->intRolid";
            $request = $this->select_all($sql);
            return $request;
        }

        public function deletePermisos(int $idrol){
            $this->intRolid = $idrol;
            $sql = "DELETE FROM permisos WHERE rolid = $this->intRolid";
            $request = $this->delete($sql);
            return $request;
        }

        public function insertPermisos(int $idrol, int $idmodulo,int $status)
        {
            $this->intRolid = $idrol;
            $this->intModuloid = $idmodulo;
            $sql = "INSERT INTO permisos(rolid,moduloid,status) VALUES (?,?,?)";
            $arrData = array($this->intRolid, $this->intModuloid,$status);
            $request = $this->insert($sql,$arrData);
            return $request;
        }

        public function permisosModulo(int $idrol)
        {
            $this->intRolid = $idrol;
            $sql = "SELECT p.rolid,p.moduloid,m.titulo as modulo, p.status FROM permisos p 
                   INNER JOIN modulo m ON p.moduloid = m.idmodulo WHERE p.rolid = $this->intRolid";
            $request = $this->select_all($sql);
            $arrPermisos = array();
            for($i=0; $i < count($request); $i++){
                $arrPermisos[$request[$i]['moduloid']] = $request[$i];
                $arrPermisos[$request[$i]['status']] = $request[$i];
            }
            return $arrPermisos;
        }
	}
?>