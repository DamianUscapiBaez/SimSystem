<?php
class ClientesModel extends Mysql
{
    private $IdCliente;
    private $TipoDocumento;
    private $NumeroDocumento;
    private $NombreCliente;
    private $TelefenoCliente;
    private $DireccionCliente;
    private $StatusCliente;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectClientes()
    {
        $sql = "SELECT * FROM client WHERE statusclient != 0";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectCliente(int $idcliente)
    {
        $this->IdCliente = $idcliente;
        $sql = "SELECT * FROM client WHERE idclient = $this->IdCliente";
        return $this->select($sql);
    }
    public function insertCliente(string $tipodocumento, string $numerodocumento, string $nombrecliente, string $direccioncliente, int $telefonocliente, int $statuscliente)
    {
        $this->TipoDocumento = $tipodocumento;
        $this->NumeroDocumento = $numerodocumento;
        $this->NombreCliente = $nombrecliente;
        $this->DireccionCliente = trim($direccioncliente) !== '' ? $direccioncliente : null;
        $this->TelefenoCliente = $telefonocliente != 0 ? $telefonocliente : null;
        $this->StatusCliente = $statuscliente;
        $return = 0;
        $sql = "SELECT * FROM cliente WHERE typedocument = '{$this->TipoDocumento}'  AND documentnumber = '{$this->NumeroDocumento}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql_insert = "INSERT INTO client (typedocument, documentnumber, nameclient, addressofclient, phoneclient, statusclient) VALUES (?, ?, ?, ?, ?, ?)";
            $arrData = array($this->TipoDocumento, $this->NumeroDocumento, $this->NombreCliente, $this->DireccionCliente, $this->TelefenoCliente, $this->StatusCliente);
            $request_insert = $this->insert($sql_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }
    public function updateCliente(int $idcliente, string $tipodocumento, string $numerodocumento, string $nombrecliente, string $direccioncliente, int $telefonocliente, int $statuscliente)
    {

        $this->IdCliente = $idcliente;
        $this->TipoDocumento = $tipodocumento;
        $this->NumeroDocumento = $numerodocumento;
        $this->NombreCliente = $nombrecliente;
        $this->DireccionCliente = trim($direccioncliente) !== '' ? $direccioncliente : null;
        $this->TelefenoCliente = ($telefonocliente ?? null) != 0 ? $telefonocliente : null;
        $this->StatusCliente = $statuscliente;

        $sql = "SELECT * FROM client WHERE tipodocumento = '$this->TipoDocumento' AND numerodocumento = '$this->NumeroDocumento' AND idcliente != $this->IdCliente";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE cliente SET typedocument = ?, documentnumber = ?, nameclient = ?, addressofclient = ?, phoneclient = ?, statusclient = ? WHERE idclient = $this->IdCliente";
            $arrData = array($this->TipoDocumento, $this->NumeroDocumento, $this->NombreCliente, $this->DireccionCliente, $this->TelefenoCliente, $this->StatusCliente);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteCliente(int $idcliente)
    {
        $this->IdCliente = $idcliente;
        $sql = "UPDATE client SET statusclient = ? WHERE idclient = $this->IdCliente";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function buscar_cliente(string $documento)
    {
        $sql = "SELECT * FROM client WHERE documentnumber = '$documento' AND statusclient = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function buscarCliente(string $cliente)
    {
        $sql = "SELECT * FROM client WHERE nameclient LIKE '%$cliente%' OR documentnumber LIKE '%$cliente' AND statusclient = 1 ";
        $request = $this->select_all($sql);
        return $request;
    }
}
?>