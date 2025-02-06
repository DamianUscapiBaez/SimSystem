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

    public function selectModulos()
    {
        $sql = "SELECT * FROM module WHERE idmodule != 1";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPermisosRol(int $idrol)
    {
        $this->intRolid = $idrol;
        $sql = "SELECT * FROM permissions WHERE roleid = $this->intRolid";
        $request = $this->select_all($sql);
        return $request;
    }

    public function deletePermisos(int $idrol)
    {
        $this->intRolid = $idrol;
        $sql = "DELETE FROM permissions WHERE roleid = $this->intRolid";
        $request = $this->delete($sql);
        return $request;
    }

    public function insertPermisos(int $idrol, int $idmodulo, int $status)
    {
        $this->intRolid = $idrol;
        $this->intModuloid = $idmodulo;
        $sql = "INSERT INTO permissions (roleid, moduleid, statuspermissions) VALUES (?, ?, ?)";
        $arrData = array($this->intRolid, $this->intModuloid, $status);
        $request = $this->insert($sql, $arrData);
        return $request;
    }

    public function permisosModulo(int $idrol)
    {
        $this->intRolid = $idrol;
        $sql = "SELECT p.roleid, p.moduleid, m.title as modulo, p.statuspermissions FROM permissions p 
                   INNER JOIN module m ON p.moduleid = m.idmodule WHERE p.roleid = $this->intRolid";
        $request = $this->select_all($sql);
        $arrPermisos = array();
        for ($i = 0; $i < count($request); $i++) {
            $arrPermisos[$request[$i]['moduleid']] = $request[$i];
            $arrPermisos[$request[$i]['statuspermissions']] = $request[$i];
        }
        return $arrPermisos;
    }
}

?>