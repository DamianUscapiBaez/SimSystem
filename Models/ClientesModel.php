<?php
	class ClientesModel extends Mysql
	{
		private $intIdCliente;
		private $intTipoDocumento;
		private $intDocumento;
        private $strNombre;
        private $intTelefono;
        private $strDireccion;
        private $intStatus;

		public function __construct()
		{
            parent::__construct();
		}

        public function selectClientes()
        {
            $sql = "SELECT * FROM cliente WHERE status !=0 ";
            $request = $this->select_all($sql);
            return $request;
        }

        public function insertCliente(int $tipo_documento,int $n_documento,string $strNombre, string $strDireccion, int $intTelefono, int $status)
        {
			$this->intTipoDocumento = $tipo_documento;
            $this->intDocumento = $n_documento;
			$this->strNombre = $strNombre;
            $this->strDireccion = $strDireccion;
            $this->intTelefono = $intTelefono;
            $this->intStatus = $status;
            $return = 0;
            $sql = "SELECT * FROM cliente WHERE documento = '{$this->intDocumento}'";
            $request = $this->select_all($sql);
            if(empty($request)){
                $sql_insert = "INSERT INTO cliente(tipo_documento,documento,nombre,direccion,telefono,status) VALUES (?,?,?,?,?,?)";
                $arrData = array($this->intTipoDocumento,
							   $this->intDocumento,
                               $this->strNombre,
                               $this->strDireccion,
                               $this->intTelefono,
                               $this->intStatus
                              );
                $request_insert = $this->insert($sql_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function selectCliente(int $idcliente)
        {
            $this->intIdCliente = $idcliente;
			$sql = "SELECT * FROM cliente WHERE idcliente = $this->intIdCliente";
			$request = $this->select($sql);
			return $request;
        }

        public function updateCliente(int $idcliente,int $tipo_documento,int $n_documento,string $strNombre, string $strDireccion, int $intTelefono, int $status){

			$this->intIdCliente = $idcliente;
			$this->intTipoDocumento = $tipo_documento;
            $this->intDocumento = $n_documento;
			$this->strNombre = $strNombre;
            $this->strDireccion = $strDireccion;
            $this->intTelefono = $intTelefono;
            $this->intStatus = $status;

			$sql = "SELECT * FROM cliente WHERE documento = $this->intDocumento AND idcliente != $this->intIdCliente";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE cliente SET tipo_documento=?,documento=?,nombre=?,direccion=?,telefono=?, status=? 
							WHERE idcliente = $this->intIdCliente ";
					$arrData = array($this->intTipoDocumento,$this->intDocumento,$this->strNombre,$this->strDireccion,$this->intTelefono,$this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}
        
        public function deleteCliente(int $idcliente)
		{
			$this->intIdCliente = $idcliente;
			$sql = "UPDATE cliente SET status = ? WHERE idcliente = $this->intIdCliente";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

        public function buscar_cliente(string $documento){
            $sql = "SELECT * FROM cliente WHERE documento = '$documento' AND status = 1";
            $request = $this->select($sql);
            return $request;
        }

        public function buscarCliente(string $cliente)
        {
            $sql = "SELECT * FROM cliente WHERE nombre LIKE '%$cliente%' OR documento LIKE '%$cliente' AND status = 1 ";
            $request = $this->select_all($sql);
            return $request;
        }
	}
?>