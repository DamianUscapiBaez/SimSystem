<?php

class RolesModel extends Mysql
{
    public $intIdrol;
    public $strRol;
    public $strDescripcion;
    public $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectRoles()
    {
        $whereAdmin = "";
        if ($_SESSION['iduser'] != 1) {
            $whereAdmin = " AND idrole != 1";
        }
        //extraer rol
        $sql = "SELECT * FROM role WHERE statusrole != 0" . $whereAdmin;
        return $this->select_all($sql);
    }

    public function selectRol(int $idrol)
    {
        //buscar rol
        $this->intIdrol = $idrol;
        $sql = "SELECT * FROM role WHERE idrole=$this->intIdrol";
        $request = $this->select($sql);
        return $request;
    }

    public function insertRol(string $rol, string $descripcion, int $status)
    {
        $return = "";
        $this->strRol = $rol;
        $this->strDescripcion = trim($descripcion) !== '' ? $descripcion : null;
        $this->intStatus = $status;

        $sql = "SELECT * FROM role WHERE namerole = '{$this->strRol}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO role(namerole, descriptionrole, statusrole) VALUES (?,?,?)";
            $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateRol(int $idrol, string $rol, string $descripcion, int $status)
    {
        $this->intIdrol = $idrol;
        $this->strRol = $rol;
        $this->strDescripcion = trim($descripcion) !== '' ? $descripcion : null;
        $this->intStatus = $status;

        $sql = "SELECT * FROM role WHERE namerole = '$this->strRol' AND  idrole != $this->intIdrol";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE role SET namerole = ?, descriptionrole = ?, statusrole = ? WHERE idrole = $this->intIdrol";
            $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteRol(int $idrol)
    {
        $this->intIdrol = $idrol;
        $sql = "UPDATE role SET statusrole = ? WHERE idrole = $this->intIdrol";
        $arrData = array(0);
        return $this->update($sql, $arrData);
    }
}
