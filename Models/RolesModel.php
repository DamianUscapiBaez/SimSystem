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
        if($_SESSION['id_usuario'] != 1){
            $whereAdmin = " AND idrol !=1";
        }
        //extraer rol
        $sql = "SELECT * FROM rol WHERE status !=0".$whereAdmin;
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectRol(int $idrol)
    {
        //buscar rol
        $this->intIdrol = $idrol;
        $sql = "SELECT * FROM rol WHERE idrol =$this->intIdrol";
        $request = $this->select($sql);
        return $request;
    }
    public function insertRol(string $rol, string $descripcion, int $status)
    {
        $return = "";
        $this->strRol = $rol;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        $sql = "SELECT * FROM rol WHERE rol = '{$this->strRol}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO rol(rol,descripcion,status) VALUES (?,?,?)";
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
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        $sql = "SELECT * FROM rol WHERE rol = '$this->strRol' AND  idrol != $this->intIdrol";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE rol SET rol = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdrol";
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
        $sql = "SELECT * FROM usuario WHERE rolid = $this->intIdrol";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE rol SET status = ? WHERE idrol = $this->intIdrol";
            $arrData = array(0);
            $request = $this->update($sql, $arrData);
            if ($request) {
                $request = 'ok';
            } else {
                $request = 'error';
            }
        } else {
            $request = 'exist';
        }
        return $request;
    }
}
