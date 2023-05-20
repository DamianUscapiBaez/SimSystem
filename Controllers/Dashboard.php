<?php
	class Dashboard extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('location:'.base_url().'/');
			}
			getPermisos(1);
		}
		 public function dashboard(){
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Page_blank');
			}
		 	$data['page_id'] = 2;
			$data['page_tag'] = "Inicio";
			$data['page_title'] = "Inicio";
			$data['page_name'] = "Inicio";
			$data['usuarios'] = $this->model->getDatos('usuario');
			$data['clientes'] = $this->model->getDatos('cliente');
			$data['proveedores'] = $this->model->getDatos('proveedor');
			$data['categorias'] = $this->model->getDatos('categoria');
			$data['productos'] = $this->model->getDatos('producto');
			$data['entradas'] = $this->model->getEntradas();
			$data['salidas'] = $this->model->getSalidas();
			$data['page_descripcion'] = "Pagina de Dashboard";
			$data['page_functions_js'] = "functions_dashboard.js";
		 	$this->views->getView($this,'dashboard',$data);
		}

		public function getStockMinimo(){
			$stockMinimo = $this->model->getStockMinimo();
			echo json_encode($stockMinimo,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getProductoSalidas(){
			$productoSalidas = $this->model->getProductoSalidas();
			echo json_encode($productoSalidas,JSON_UNESCAPED_UNICODE);
			die();
		}
	}
?>