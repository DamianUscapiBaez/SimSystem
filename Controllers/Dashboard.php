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

    public function dashboard()
    {
        if (empty($_SESSION['permissionsMod']['statuspermissions'])) {
            header('Location:' . base_url() . '/Page_blank');
        }
        $data['page_id'] = 2;
        $data['page_tag'] = "Inicio";
        $data['page_title'] = "INICIO";
        $data['page_name'] = "Inicio";
        $data['usuarios'] = $this->model->getDatos('user', 'statususer');
        $data['clientes'] = $this->model->getDatos('client', 'statusclient');
        $data['proveedores'] = $this->model->getDatos('provider', 'statusprovider');
        $data['categorias'] = $this->model->getDatos('category', 'statuscategory');
        $data['productos'] = $this->model->getDatos('product', 'statusproduct');
        // $data['entradas'] = $this->model->getEntradas();
        // $data['salidas'] = $this->model->getSalidas();
        $data['page_descripcion'] = "Pagina de Dashboard";
        $data['page_functions_js'] = "functions_dashboard.js";
        $this->views->getView($this, 'dashboard', $data);
    }

    public function getStockMinimo()
    {
        $stockMinimo = $this->model->getStockMinimo();
        echo json_encode($stockMinimo, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getProductoSalidas()
    {
        $productoSalidas = $this->model->getProductoSalidas();
        echo json_encode($productoSalidas, JSON_UNESCAPED_UNICODE);
        die();
    }
}

?>