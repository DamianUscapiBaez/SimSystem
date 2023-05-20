<?php
	class Usuarios extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('location:'.base_url().'/');
			}
			getPermisos(4);
		}
		 public function Usuarios(){
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Dashboard');
			}
			$data['page_tag'] = "usuarios";
			$data['page_title'] = "Usuarios";
			$data['page_name'] = "usuarios";
			$data['page_descripcion'] = "Pagina de usuario";
			$data['page_functions_js'] = "functions_usuarios.js";
		 	$this->views->getView($this,'usuarios',$data);
		}
		public function setUsuario()
		{
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtEmail'])){
					$arrResponse = array("status" => false,"msg" => 'Datos incorrectos.');
				}
				else{
					
					$idUsuario = intval($_POST['idUsuario']);
					$srtNombre = ucwords(strClean($_POST['txtNombre']));
					$srtEmail = strtolower(strClean($_POST['txtEmail']));
					if($idUsuario == 0){
						$option = 1;
						$srtUsername = ucwords(strClean($_POST['txtUsername']));
						$intTipoId = intval(strClean($_POST['listRolid']));
						$srtStatus = intval(strClean($_POST['listStatus']));
						$strPassword = empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);
						$request_user = $this->model->insertUsuario($srtUsername,$srtNombre,$srtEmail,$strPassword,$intTipoId,$srtStatus); 	
					}else{
						$option = 2;
						if($idUsuario==1){
							$srtUsername = "";
							$intTipoId = 0;
							$srtStatus = 0;
							$strPassword = empty($_POST['txtPassword']) ? "": hash("SHA256",$_POST['txtPassword']);
							$request_user = $this->model->updateUsuario($idUsuario,$srtUsername,$srtNombre,$srtEmail,$strPassword,$intTipoId,$srtStatus);
						}else{
							$srtUsername = ucwords(strClean($_POST['txtUsername']));
							$intTipoId = intval(strClean($_POST['listRolid']));
							$srtStatus = intval(strClean($_POST['listStatus']));
							$strPassword = empty($_POST['txtPassword']) ? "": hash("SHA256",$_POST['txtPassword']);
							$request_user = $this->model->updateUsuario($idUsuario,$srtUsername,$srtNombre,$srtEmail,$strPassword,$intTipoId,$srtStatus);
						}	
					}
					if($request_user > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		
		public function getUsuarios()
		{
			$arrData = $this->model->selectUsuarios();
			for ($i = 0; $i < count($arrData); $i++) {
				$btnView = "";
				$btnEdit = "";
				$btnDelete = "";
			    if ($arrData[$i]['status'] == 1) {
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				} else {
				   $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}
				$btnView = '<button class="btn btn-success btn-sm btnViewUsuario mr-2" onclick="fntViewUsuario(' . $arrData[$i]['idusuario'] . ')" title="Ver usuario"><i class="fa fa-eye"></i></button>';
				if(($_SESSION['id_usuario'] == 1 and $_SESSION['userData']['idrol'] == 1) || ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1)){
					$btnEdit = '<button class="btn btn-warning btn-sm btnEditUsuario mr-2" onclick="fntEditUsuario(' . $arrData[$i]['idusuario'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
				}else{
					$btnEdit = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-pencil-alt"></i></button>';
				}
				if(($_SESSION['id_usuario'] == 1 and $_SESSION['userData']['idrol'] == 1) || ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) and ($_SESSION['userData']['idusuario'] != $arrData[$i]['idusuario'])){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario mr-2" onclick="fntDelUsuario(' . $arrData[$i]['idusuario'] . ')" title="Eliminar"><i class="fa fa-trash"></i></button>';
				}else{
					$btnDelete = '<button class="btn btn-secondary btn-sm mr-2" disabled><i class="fa fa-trash"></i></button>';
				}
				$arrData[$i]['options'] ='<div class="text-center">'.$btnView.''.$btnEdit.''.$btnDelete.'</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getUsuario(int $idpersona)
		{
			$idusuario = intval($idpersona);
			if($idusuario > 0){
				$arrData = $this->model->selectUsuario($idusuario);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delUsuario()
		{
			if($_POST){
				$intIdpersona = intval($_POST['idUsuario']);
				$requestDelete = $this->model->deleteUsuario($intIdpersona);
				if($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function perfil()
		{
			$data['page_tag'] = "perfil";
			$data['page_title'] = "perfil";
			$data['page_name'] = "perfil";
			$data['page_content'] = "Pagina Principal de perfil";
			$data['page_functions_js'] = "functions_usuarios.js";
		 	$this->views->getView($this,'perfil',$data);
		}
		public function putPerfil(){
			if($_POST){
				if(empty($_POST['txtUsername']) || empty($_POST['txtNombre']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['id_usuario'];
					$srtUsername = strClean($_POST['txtUsername']);
					$strNombre = strClean($_POST['txtNombre']);
					$strPassword = "";
					if(!empty($_POST['txtPassword'])){
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}
					$request_user = $this->model->updatePerfil($idUsuario,
																$srtUsername, 
																$strNombre,
																$strPassword);
					if($request_user)
					{
						sessionUser($idUsuario);
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