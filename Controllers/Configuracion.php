<?php
	class Configuracion extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('location:'.base_url().'/');
			}
			getPermisos(2);
		}
		public function Configuracion(){
			if(empty($_SESSION['permissionsMod']['statuspermissions'])){
				header('Location:'.base_url().'/Dashboard');
			}
			$data['page_title'] = "DATOS DE EMPRESA";
			$data['page_tag'] = "Datos de la empresa";
			$data['page_name'] = "Datos de la empresa";
			$data['page_descripcion'] = "Pagina de configuracion de datos de la empresa";
			$data['page_functions_js'] = "functions_configuracion.js";
			$_SESSION['dataConfig'] = $this->model->configuracion();
		 	$this->views->getView($this,'configuracion',$data);
		}

		public function Update_Business(){
			if($_POST){
				if(empty($_POST['txtRuc']) || empty($_POST['txtNombre'])|| empty($_POST['txtDireccion'])|| empty($_POST['txtTelefono'])|| empty($_POST['txtEmail']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$intIdempresa = $_SESSION['dataConfig']['idempresa'];
					$strRuc = strClean($_POST['txtRuc']);
					$strNombre = strClean($_POST['txtNombre']);
					$strDireccion = strClean($_POST['txtDireccion']);
					$strTelefono = strClean($_POST['txtTelefono']);
					$strEmail = strClean($_POST['txtEmail']);
					$request_user = $this->model->updateBusiness($intIdempresa,$strRuc,$strNombre,$strDireccion,$strTelefono,$strEmail);
					if($request_user)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}
?>

