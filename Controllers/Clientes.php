<?php
	class Clientes extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('location:'.base_url().'/');
			}
			getPermisos(8);
		}
		 public function Clientes(){
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Dashboard');
			}
			$data['page_tag'] = "Clientes";
			$data['page_title'] = "clientes";
			$data['page_name'] = "clientes";
			$data['page_descripcion'] = "Pagina de clientes";
			$data['page_functions_js'] = "functions_clientes.js";
		 	$this->views->getView($this,'clientes',$data);
		}
		public function getClientes()
		{
			$arrData = $this->model->selectClientes();
			for ($i = 0; $i < count($arrData); $i++) {
				if ($arrData[$i]['tipo_documento'] == 1) {
					$arrData[$i]['tipo_documento'] = '<b>RUC</b>';
				} else {
				   $arrData[$i]['tipo_documento'] = '<b>DNI</b>';
				}
			    if ($arrData[$i]['status'] == 1) {
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				} else {
				   $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}
				$btnView = '<button class="btn btn-success btn-sm btnViewCliente mr-2" onclick="fntViewCliente(' . $arrData[$i]['idcliente'] . ')" title="Ver categoria"><i class="fa fa-eye"></i></button>';
				$btnEdit = '<button class="btn btn-warning btn-sm btnEditCliente mr-2" onclick="fntEditCliente(' . $arrData[$i]['idcliente'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
				$btnDele = '<button class="btn btn-danger btn-sm btnDelCliente mr-2" onclick="fntDelCliente(' . $arrData[$i]['idcliente'] . ')" title="Eliminar"><i class="fa fa-trash"></i></button>';
				$arrData[$i]['options'] ='<div class="text-center">'.$btnView.''.$btnEdit.''.$btnDele.'</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function setCliente()
		{
			if($_POST){
				if(empty($_POST['txtDocumento']) || empty($_POST['txtNombre']) || empty($_POST['txtDireccion']) || empty($_POST['txtTelefono'])){
					$arrResponse = array("status" => false,"msg" => 'Datos incorrectos');
				}
				else{
					$idCliente = intval($_POST['idcliente']);
					$tipo_documento = intval($_POST['listDocumento']);
					$n_documento = intval($_POST['txtDocumento']);
					$srtNombre = ucwords(strClean($_POST['txtNombre']));
					$srtDireccion = strClean($_POST['txtDireccion']);
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$intStatus = intval(strClean($_POST['listStatus']));

					if($idCliente == 0){
						$option = 1;
						$request_cliente = $this->model->insertCliente($tipo_documento,$n_documento,$srtNombre,$srtDireccion,$intTelefono,$intStatus); 	
					}else{
						$option = 2;
						$request_cliente = $this->model->updateCliente($idCliente,$tipo_documento,$n_documento,$srtNombre,$srtDireccion,$intTelefono,$intStatus); 	
					}
					if($request_cliente > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.','id'=> $request_cliente);
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_cliente == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el documento ingresado ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getCliente($idcliente)
		{
			$intIdcliente = intval(strClean($idcliente));
			if ($intIdcliente > 0) {
				$arrData = $this->model->selectCliente($intIdcliente);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delCliente()
		{
			if($_POST){
				$intIdcliente = intval($_POST['idcliente']);
				$requestDelete = $this->model->deleteCliente($intIdcliente);
				if($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cliente');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cliente.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function buscarCliente($documento){
			$intDocumento = strClean($documento);
			$arrData = $this->model->buscar_cliente($intDocumento);
			if($arrData){
				$arrResponse = array('status' => true, 'data' => $arrData);
			} else {
				$arrResponse = array('status' => false, 'msg' => 'Los datos del cliente no encontrados o se encuenta inactivo');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function buscar_cliente($cliente){
			$arrData = $this->model->buscarCliente($cliente);
			if (empty($arrData)) {
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
			} else {
				$arrResponse = array('status' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
	}
?>