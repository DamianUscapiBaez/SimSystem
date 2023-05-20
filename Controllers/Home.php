<?php
class Home extends Controller
{
    public function __construct() {
        session_start();
        if(isset($_SESSION['login'])){
            header('location:'.base_url().'/Dashboard');
        }
        parent::__construct();
    }
    public function login()
    {
        $data['page_title'] = "Login";
        $data['page_functions_js'] = "functions_login.js";
        $this->views->getView($this, "login",$data);
    }
    public function loginUser()
    {
        if($_POST){
            if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            }else{
                $strUsuario = strClean($_POST['txtEmail']);
                $strPassword = hash("SHA256",$_POST['txtPassword']);
                $resquest = $this->model->loginUser($strUsuario,$strPassword);
                if(empty($resquest)){
                    $arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto');
                }else{
                    $arrData = $resquest;
                    if($arrData['status'] == 1){
                        $_SESSION['id_usuario']	= $arrData['idusuario'];
                        $_SESSION['login'] = true;
                        $arrData = $this->model->sessionLogin($_SESSION['id_usuario']);
                        $_SESSION['userData'] = $arrData;
                        
                        $arrResponse = array('status' => true, 'msg' => 'Ok');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'Usuario inactivo');
                    }
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
