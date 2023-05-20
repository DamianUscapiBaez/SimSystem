<?php
class ProveedoresModel extends Mysql
{
    public $intIdproveedor;
    public $intRuc;
    public $strProveedor;
    public $strDireccion;
    public $strTelefono;
    public $intStatus;
    public function __construct()
    {
        parent::__construct();
    }

    public function selectProveedores()
    {
        //extraer Categoria
        $sql = "SELECT * FROM proveedor WHERE status !=0";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectProveedor(int $idproveedor)
    {
        //buscar categoria
        $this->intIdproveedor = $idproveedor;
        $sql = "SELECT * FROM proveedor WHERE idproveedor =$this->intIdproveedor";
        $request = $this->select($sql);
        return $request;
    }
    public function insertProveedor(int $ruc,string $proveedor, string $direccion, string $telefono, int $status)
    {
        $return = "";
        $this->intRuc = $ruc;
        $this->strProveedor = $proveedor;
        $this->strDireccion = $direccion;
        $this->strTelefono = $telefono;
        $this->intStatus = $status;

        $sql = "SELECT * FROM proveedor WHERE nombre = '{$this->strProveedor}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO proveedor (ruc,nombre,direccion,telefono,status) VALUES (?,?,?,?,?)";
            $arrData = array($this->intRuc,$this->strProveedor, $this->strDireccion,$this->strTelefono,$this->intStatus);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }
    public function updateProveedor(int $idproveedor, int $ruc,string $proveedor, string $direccion, string $telefono, int $status)
    {
        $this->intIdproveedor = $idproveedor;
        $this->intRuc = $ruc;
        $this->strProveedor = $proveedor;
        $this->strDireccion = $direccion;
        $this->strTelefono = $telefono;
        $this->intStatus = $status;

        $sql = "SELECT * FROM proveedor WHERE nombre = '$this->strProveedor' AND  idproveedor != $this->intIdproveedor";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE proveedor SET ruc = ?,nombre = ?, direccion = ?,telefono = ?,status = ? WHERE idproveedor = $this->intIdproveedor";
            $arrData = array($this->intRuc,$this->strProveedor,$this->strDireccion,$this->strTelefono,$this->intStatus);
            $request = $this->update($sql,$arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteProveedor(int $idproveedor)
    {
        $this->intIdproveedor = $idproveedor;
        $sql = "SELECT * FROM producto WHERE proveedorid = $this->intIdproveedor";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE proveedor SET status = ? WHERE idproveedor = $this->intIdproveedor";
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

    public function buscar_proveedor(string $ruc){
        $sql = "SELECT * FROM proveedor WHERE ruc = '$ruc' AND status = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function buscarProveedor(string $proveedor)
    {
        $sql = "SELECT * FROM proveedor WHERE nombre LIKE '%$proveedor%' OR ruc LIKE '%$proveedor' AND status = 1 ";
        $request = $this->select_all($sql);
        return $request;
    }
}
