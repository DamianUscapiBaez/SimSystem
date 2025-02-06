<?php
class ProveedoresModel extends Mysql
{
    public $IdProveedor;
    public $TipoDocumento;
    public $NumeroDocumento;
    public $NombreProveedor;
    public $CorreoProveedor;
    public $TelefonoProveedor;
    public $DireccionProveedor;

    public $StatusProveedor;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectProveedores()
    {
        //extraer Categoria
        $sql = "SELECT * FROM provider WHERE statusprovider != 0";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectProveedor(int $idproveedor)
    {
        //buscar categoria
        $this->IdProveedor = $idproveedor;
        $sql = "SELECT * FROM provider WHERE idprovider = $this->IdProveedor";
        $request = $this->select($sql);
        return $request;
    }
    public function buscarProveedorNombreNumero(string $busqueda)
    {
        $sql = "SELECT * FROM provider WHERE nameprovider LIKE '%$busqueda%' OR documentnumber LIKE '%$busqueda%' AND statusprovider = 1";
        $request = $this->select_all($sql);
        return $request;
    }
    public function buscarProveedorNumero(string $busqueda)
    {
        $sql = "SELECT * FROM provider WHERE documentnumber = '$busqueda' AND statusprovider = 1";
        $request = $this->select($sql);
        return $request;
    }
    public function insertProveedor(string $tipodocumento, string $numerodocumento, string $nombreproveedor, string $correoproveedor, string $telefonoproveedor, string $direccionproveedor, int $statusproveedor)
    {
        $return = "";
        $this->TipoDocumento = $tipodocumento;
        $this->NumeroDocumento = $numerodocumento;
        $this->NombreProveedor = $nombreproveedor;
        $this->CorreoProveedor = trim($correoproveedor) !== '' ? $correoproveedor : null;
        $this->TelefonoProveedor = $telefonoproveedor !== 0 ? $telefonoproveedor : null;
        $this->DireccionProveedor = trim($direccionproveedor) !== '' ? $direccionproveedor : null;
        $this->StatusProveedor = $statusproveedor;

        $sql = "SELECT * FROM provider WHERE nameprovider = '$this->NombreProveedor'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO provider (typedocument, documentnumber, nameprovider, emailprovider, phonenumber, addressofprovider, statusprovider) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $arrData = array($this->TipoDocumento, $this->NumeroDocumento, $this->NombreProveedor, $this->CorreoProveedor, $this->TelefonoProveedor, $this->DireccionProveedor, $this->StatusProveedor);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }
    public function updateProveedor(int $idproveedor, string $tipodocumento, string $numerodocumento, string $nombreproveedor, string $correoproveedor, string $telefonoproveedor, string $direccionproveedor, int $statusproveedor)
    {
        $this->IdProveedor = $idproveedor;
        $this->TipoDocumento = $tipodocumento;
        $this->NumeroDocumento = $numerodocumento;
        $this->NombreProveedor = $nombreproveedor;
        $this->CorreoProveedor = trim($correoproveedor) !== '' ? $correoproveedor : null;
        $this->TelefonoProveedor = $telefonoproveedor !== 0 ? $telefonoproveedor : null;
        $this->DireccionProveedor = trim($direccionproveedor) !== '' ? $direccionproveedor : null;
        $this->StatusProveedor = $statusproveedor;

        $sql = "SELECT * FROM provider WHERE nameprovider = '$this->NombreProveedor' AND  idprovider != $this->IdProveedor";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE provider SET typedocument = ?, documentnumber = ?, nameprovider = ?, emailprovider = ?, phonenumber = ?, addressodprovider = ?, statusprovider = ? WHERE idprovider = ?";
            $arrData = array($this->TipoDocumento, $this->NumeroDocumento, $this->NombreProveedor, $this->CorreoProveedor, $this->TelefonoProveedor, $this->DireccionProveedor, $this->StatusProveedor, $this->IdProveedor);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteProveedor(int $idproveedor)
    {
        $this->IdProveedor = $idproveedor;
        $sql = "UPDATE provider SET statusprovider = ? WHERE idprovider = $this->IdProveedor";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }

    public function buscar_proveedor(string $ruc)
    {
        $sql = "SELECT * FROM provider WHERE documentnumber = '$ruc' AND statusprovider = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function buscarProveedor(string $proveedor)
    {
        $sql = "SELECT * FROM provider WHERE nameprovider LIKE '%$proveedor%' OR documentnumber LIKE '%$proveedor' AND statusprovider = 1 ";
        $request = $this->select_all($sql);
        return $request;
    }
}
