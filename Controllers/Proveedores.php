<?php
	class Proveedores extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('location:'.base_url().'/');
			}
			getPermisos(7);
		}
		public function Proveedores(){
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Dashboard');
			}
			$data['page_tag'] = "Proveedores";
			$data['page_title'] = "Proveedores de productos";
			$data['page_name'] = "Proveedores";
			$data['page_descripcion'] = "Pagina de proveedores para productos";
			$data['page_functions_js'] = "functions_proveedores.js";
		 	$this->views->getView($this,'proveedores',$data);
		}
		public function getProveedores()
		{
		    $arrData = $this->model->selectProveedores();
			for ($i = 0; $i < count($arrData); $i++) {
			    if ($arrData[$i]['status'] == 1) {
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				} else {
				   $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}
				$btnView = '<button class="btn btn-success btn-sm btnViewProveedor mr-2" onclick="fntViewProveedor(' . $arrData[$i]['idproveedor'] . ')" title="Ver categoria"><i class="fa fa-eye"></i></button>';
				$btnEdit = '<button class="btn btn-warning btn-sm btnEditProveedor mr-2" onclick="fntEditProveedor(' . $arrData[$i]['idproveedor'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
				$btnDele = '<button class="btn btn-danger btn-sm btnDelProveedor mr-2" onclick="fntDelProveedor(' . $arrData[$i]['idproveedor'] . ')" title="Eliminar"><i class="fa fa-trash"></i></button>';
				$arrData[$i]['options'] ='<div class="text-center">'.$btnView.''.$btnEdit.''.$btnDele.'</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}
		public function getProveedor($idproveedor)
		{
			$intIdproveedor = intval(strClean($idproveedor));
			if ($intIdproveedor > 0) {
				$arrData = $this->model->selectProveedor($intIdproveedor);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setProveedor()
		{
			if($_POST){
				if(empty($_POST['txtRuc']) || empty($_POST['txtNombre']) || empty($_POST['txtDireccion']) || empty($_POST['txtTelefono']) ||  empty($_POST['listStatus'])){
					$arrResponse = array("status" => false, "msg" => 'Datos	incorrectos');
				}else{
					$intIdproveedor = intval($_POST['idProveedor']);
					$intRuc = strClean($_POST['txtRuc']);
					$strProveedor = strClean($_POST['txtNombre']);
					$strDireccion = strClean($_POST['txtDireccion']);
					$strTelefono = strClean($_POST['txtTelefono']);
					$intStatus = intval($_POST['listStatus']);

					$request_proveedor = "";
					if ($intIdproveedor == 0) {
						$request_proveedor = $this->model->insertProveedor($intRuc,$strProveedor, $strDireccion,$strTelefono,$intStatus);
						$option = 1;
					} else {
						$request_proveedor = $this->model->updateProveedor($intIdproveedor,$intRuc,$strProveedor, $strDireccion,$strTelefono,$intStatus);
						$option = 2;
					}
					if ($request_proveedor> 0) {
						if ($option == 1) {
							$arrResponse = array('status' => true, 'msg' => 'Datos Guardados con Exito.','id'=>$request_proveedor);
						} else {
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados con Exito.');
						}
					} else if ($request_proveedor == 'exist') {
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el proveedor ya existe.');
					} else {
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar datos.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		public function delProveedor()
		{
			if ($_POST) {
				$intIdproveedor = intval($_POST['idproveedor']);
				//$requestDelete = $this->moldel->deleteRol($intIdrol);
				$requestDelete = $this->model->deleteProveedor($intIdproveedor);
				if ($requestDelete == "ok") {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la proveedor');
				} elseif ($requestDelete == "exist") {
					$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar el proveedor asosiado a productos');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el proveedor');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectProveedores(){
			$htmlOptions = "";
			$arrData = $this->model->selectProveedores();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
						$htmlOptions .= '<option value="'.$arrData[$i]['idproveedor'].'">'.$arrData[$i]['nombre'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();	
		}

		public function buscarProveedor($ruc){
			$intRuc = strClean($ruc);
			$arrData = $this->model->buscar_proveedor($intRuc);
			if($arrData){
				$arrResponse = array('status' => true, 'data' => $arrData);
			} else {
				$arrResponse = array('status' => false, 'msg' => 'Los datos del proveedor no encontrados o se encuenta inactivo');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function buscar_proveedor($proveedor){
			$arrData = $this->model->buscarProveedor($proveedor);
			if (empty($arrData)) {
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
			} else {
				$arrResponse = array('status' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
	}
