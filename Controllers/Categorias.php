 <?php
	class Categorias extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('location:'.base_url().'/');
			}
			getPermisos(5);
		}
		public function Categorias(){
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Dashboard');
			}
			$data['page_tag'] = "categorias";
			$data['page_title'] = "Categorias de productos";
			$data['page_name'] = "categorias";
			$data['page_descripcion'] = "Pagina categorias para productos";
			$data['page_functions_js'] = "functions_categorias.js";
		 	$this->views->getView($this,'categorias',$data);
		}
		public function getCategorias()
		{
		    $arrData = $this->model->selectCategorias();
			for ($i = 0; $i < count($arrData); $i++) {
				$arrData[$i]['imagen'] = '<img class="img_table" src="'.base_url()."/Assets/images/uploads/".$arrData[$i]['portada'].'">';
			    if ($arrData[$i]['status'] == 1) {
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				} else {
				   $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}
				$btnViewCat = '<button class="btn btn-success btn-sm btnViewCategoria mr-2" onclick="fntViewCategoria(' . $arrData[$i]['idcategoria'] . ')" title="Ver categoria"><i class="fa fa-eye"></i></button>';
				$btnEditCat = '<button class="btn btn-warning btn-sm btnEditCategoria mr-2" onclick="fntEditCategoria(' . $arrData[$i]['idcategoria'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
				$btnDeleCat = '<button class="btn btn-danger btn-sm btnDelCategoria mr-2" onclick="fntDelCategoria(' . $arrData[$i]['idcategoria'] . ')" title="Eliminar"><i class="fa fa-trash"></i></button>';
					
				$arrData[$i]['options'] ='<div class="text-center">'.$btnViewCat.''.$btnEditCat.''.$btnDeleCat.'</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}
		public function getCategoria($idcategoria)
		{
			$intIdcategoria = intval(strClean($idcategoria));
			if ($intIdcategoria > 0) {
				$arrData = $this->model->selectCategoria($intIdcategoria);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrData['url_portada'] = media().'/images/uploads/'.$arrData['portada'];
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setCategoria()
		{
			// dep($_FILES);
			// die();
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['listStatus'])){
					$arrResponse = array("status" => false, "msg" => 'Datos	incorrectos');
				}else{
					$intIdcategoria = intval($_POST['idCategoria']);
					$strCategoria = strClean($_POST['txtNombre']);
					$strDescripcion = strClean($_POST['txtDescripcion']);
					$intStatus = intval($_POST['listStatus']);

					$foto = $_FILES['foto'];
					$nombre_foto = $foto['name'];
					$type = $foto['type'];
					$url_temp = $foto['tmp_name'];
					$imgPortada = 'portada_categoria.png';
					if($nombre_foto != ''){
						$imgPortada = 'img_'.md5(date('d-m-Y H:m:s')).'.jpg';
					}
					if ($intIdcategoria == 0) {
						//clear
						$request_categoria = $this->model->insertCategoria($strCategoria, $strDescripcion,$imgPortada, $intStatus);
						$option = 1;
					} else {
						if($nombre_foto == ''){
							if($_POST['foto_actual'] != 'portada_categoria.png' && $_POST['foto_remove'] == 0){
								$imgPortada = $_POST['foto_actual'];
							}
						}
						$request_categoria = $this->model->updateCategoria($intIdcategoria, $strCategoria,$strDescripcion,$imgPortada,$intStatus);
						$option = 2;
					}
					if ($request_categoria> 0) {
						if ($option == 1) {
							$arrResponse = array('status' => true, 'msg' => 'Datos Guardados con Exito.');
							if($nombre_foto !=''){uploadImage($foto,$imgPortada);}
						} else {
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados con Exito.');
							if($nombre_foto !=''){
								uploadImage($foto,$imgPortada);
							}
							if(($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png') 
							||($nombre_foto != '' && $_POST['foto_actual'] != 'portada_categoria.png')){
								deleteFile($_POST['foto_actual']);
							}
						}
					} else if ($request_categoria == 'exist') {
						$arrResponse = array('status' => false, 'msg' => '¡Atención! la categoria ya existe.');
					} else {
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar datos.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		public function delCategoria()
		{
			if ($_POST) {
				$intIdcategoria = intval($_POST['idcategoria']);
				//$requestDelete = $this->moldel->deleteRol($intIdrol);
				$requestDelete = $this->model->deleteCategoria($intIdcategoria);
				if ($requestDelete == "ok") {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la categoria');
				} elseif ($requestDelete == "exist") {
					$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar la categoria asosiado a productos');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la categoria');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getSelectCategorias(){
			$htmlOptions = "";
			$arrData = $this->model->selectCategorias();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
						$htmlOptions .= '<option value="'.$arrData[$i]['idcategoria'].'">'.$arrData[$i]['nombre'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();	
		}
	}
?>