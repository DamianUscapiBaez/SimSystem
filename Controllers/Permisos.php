<?php
	class Permisos extends Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function getPermisosRol(int $idrol){
            $rolid = intval($idrol);
            if($rolid > 0){
                $arrModulos = $this->model->selectModulos();
                $arrPermisosRol = $this->model->selectPermisosRol($rolid);
                $arrPermisos = array('status' => 0);
                $arrPermisoRol = array('idrol' => $rolid);
                if(empty($arrPermisosRol)){
                    for($i=0; $i < count($arrModulos); $i++){
                        $arrModulos[$i]['permisos'] = $arrPermisos; 
                    }
                }else{
                    for($i=0;$i < count($arrModulos);$i++){
                        $arrPermisos = array('status' => 0);
                        if(isset($arrPermisosRol[$i])){
                            $arrPermisos = array('status' => $arrPermisosRol[$i]['status']);
                        }
                        $arrModulos[$i]['permisos'] = $arrPermisos;
                    }
                }
                $arrPermisoRol['modulos'] = $arrModulos;
                $html = getModal("modalPermisos",$arrPermisoRol);
            }
            die();
        }
        public function setPermisos(){
            if($_POST){
                $intIdrol = intval($_POST['idrol']);
                $modulos = $_POST['modulos'];
                $this->model->deletePermisos($intIdrol);
                foreach($modulos as $modulo){
                    $idModulo = $modulo['idmodulo'];
                    $status = empty($modulo['status']) ? 0 : 1;
                    $requestPermiso = $this->model->insertPermisos($intIdrol,$idModulo,$status);
                }
                if($requestPermiso > 0){
                    $arrResponse = array('status' => true,'msg' => 'Permisos asignados correctamente');
                }else{
                    $arrResponse = array('status' => false,'msg' => 'No es posible asignar los permisos'); 
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
	}
?>