<?php 
	class Productos extends Controller{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/');
				die();
			}
			getPermisos(6);
		}

		public function Productos()
		{
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Dashboard');
			}
			$data['page_tag'] = "Productos";
			$data['page_title'] = "PRODUCTOS";
			$data['page_name'] = "productos";
            $data['page_descripcion'] = "productos";
			$data['page_functions_js'] = "functions_productos.js";
			$this->views->getView($this,"productos",$data);
		}
		public function getProductos()
		{
			$arrData = $this->model->selectProductos();
			for ($i=0; $i < count($arrData); $i++) {
				$arrData[$i]['precio_Compra'] = 'S/ '.$arrData[$i]['precio_compra'];
				$arrData[$i]['precio_Venta'] = 'S/ '.$arrData[$i]['precio_venta'];
				$arrData[$i]['imagen'] = '<img class="img_table" src="'.base_url()."/Assets/images/uploads/".$arrData[$i]['portada'].'">';
				if ($arrData[$i]['status'] == 1) {
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				} else {
				   $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}
				$btnView = '<button class="btn btn-success btn-sm mr-2" onClick="fntViewInfo('.$arrData[$i]['idproducto'].')" title="Ver producto"><i class="fa fa-eye"></i></button>';
				$btnEdit = '<button class="btn btn-warning  btn-sm mr-2" onClick="fntEditInfo('.$arrData[$i]['idproducto'].')" title="Editar producto"><i class="fas fa-pencil-alt"></i></button>';
				$btnDelete = '<button class="btn btn-danger btn-sm mr-2" onClick="fntDelInfo('.$arrData[$i]['idproducto'].')" title="Eliminar producto"><i class="fa fa-trash"></i></button>';
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		public function setProducto(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria'])  || empty($_POST['precio_compra']) || empty($_POST['precio_venta']) || empty($_POST['txtDescripcion'])|| empty($_POST['txtStock']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					
					$idProducto = intval($_POST['idProducto']);
					$strNombre = strClean($_POST['txtNombre']);
					$strCodigo = strClean($_POST['txtCodigo']);
					$precio_compra = strClean($_POST['precio_compra']);
					$precio_venta = strClean($_POST['precio_venta']);
					$intStock = intval($_POST['txtStock']);
					$strDescripcion = strClean($_POST['txtDescripcion']);
					$intCategoriaId = intval($_POST['listCategoria']);
					$intProveedorId = intval($_POST['listProveedor']);
					$usuarioid = $_SESSION['id_usuario'];
					$intStatus = intval($_POST['listStatus']);
					$total = $precio_compra * $intStock;

					$request_producto = "";

					$foto = $_FILES['foto'];
					$nombre_foto = $foto['name'];
					$type = $foto['type'];
					$url_temp = $foto['tmp_name'];
					$imgPortada = 'portada_categoria.png';
					if($nombre_foto != ''){
						$imgPortada = 'img_'.md5(date('d-m-Y H:m:s')).'.jpg';
					}
					if($idProducto == 0)
					{
						$option = 1;
						$request_producto = $this->model->insertProducto($strNombre,$strCodigo,$precio_compra,$precio_venta,$intStock,$strDescripcion,$intCategoriaId,$imgPortada,$intStatus);
					}else{
						if($nombre_foto == ''){
							if($_POST['foto_actual'] != 'portada_categoria.png' && $_POST['foto_remove'] == 0){
								$imgPortada = $_POST['foto_actual'];
							}
						}
						$option = 2;
						$request_producto = $this->model->updateProducto($idProducto,$strNombre,$strCodigo,$precio_compra,$precio_venta,$intStock,$strDescripcion,$intCategoriaId,$imgPortada,$intStatus);
					}
					if($request_producto > 0 )
					{
						if($option == 1){
						    if($nombre_foto !=''){uploadImage($foto,$imgPortada);}
							$request_entrada = $this->model->insert_entrada($usuarioid,$intProveedorId,$total);
							if($request_entrada){
								$idproducto = $this->model->select_producto();
								$this->model->insert_detalle_entrada($request_entrada['identrada'],$idproducto['idproducto'],$intStock,$precio_compra,$total);
								// movimiento
								$request_movimiento = $this->model->insertMovimientos($strNombre,$intStock,$total);
								if($request_movimiento){
									$this->model->insert_detalle_movimiento($request_movimiento['idmovimiento'],$intStock,$precio_compra);
									$arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Datos guardados correctamente.');
								}
							}
						}else{
							if($nombre_foto !=''){
								uploadImage($foto,$imgPortada);
							}
							$arrResponse = array('status' => true, 'idproducto' => $idProducto, 'msg' => 'Datos Actualizados correctamente.');
							if(($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png') 
							||($nombre_foto != '' && $_POST['foto_actual'] != 'portada_categoria.png')){
								deleteFile($_POST['foto_actual']);
							}
						}
					}else if($request_producto == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! El codigo o el nombre del producto ya existen');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getProducto($idproducto){
			$idproducto = intval($idproducto);
			if($idproducto > 0){
				$arrData = $this->model->selectProducto($idproducto);
				if(empty($arrData)){
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrData['url_portada'] = media().'/images/uploads/'.$arrData['portada'];
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function delProducto(){
			if($_POST){
				$intIdproducto = intval($_POST['idProducto']);
				$requestDelete = $this->model->deleteProducto($intIdproducto);
				if($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el producto');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setImage(){
			if($_POST){
				if(empty($_POST['idproducto'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de dato.');
				}else{
					$idProducto = intval($_POST['idproducto']);
					$foto      = $_FILES['foto'];
					$imgNombre = 'pro_'.md5(date('d-m-Y H:m:s')).'.jpg';
					$request_image = $this->model->insertImage($idProducto,$imgNombre);
					if($request_image){
						$uploadImage = uploadImage($foto,$imgNombre);
						$arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error de carga.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delFile(){
			if($_POST){
				if(empty($_POST['idproducto']) || empty($_POST['file'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					//Eliminar de la DB
					$idProducto = intval($_POST['idproducto']);
					$imgNombre  = strClean($_POST['file']);
					$request_image = $this->model->deleteImage($idProducto,$imgNombre);

					if($request_image){
						$deleteFile =  deleteFile($imgNombre);
						$arrResponse = array('status' => true, 'msg' => 'Archivo eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}

 ?>