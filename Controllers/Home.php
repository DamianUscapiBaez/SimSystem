<?php

class Home extends Controller
{
    public function __construct()
    {
        session_start();
        if (isset($_SESSION['login'])) {
            header('location:' . base_url() . '/Dashboard');
        }
        parent::__construct();
    }

    public function login()
    {
        $data['page_title'] = "INICIAR SESIÓN";
        $data['page_functions_js'] = "functions_login.js";
        $this->views->getView($this, "login", $data);
    }

    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
                $response = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $username = strClean($_POST['txtEmail']);
                $password = hash("SHA256", $_POST['txtPassword']);
                $result = $this->model->loginUser($username, $password);
                if (empty($result)) {
                    $response = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto');
                } else {
                    $data = $result;
                    if ($data['statususer'] == 1) {
                        $_SESSION['iduser'] = $data['iduser'];
                        $_SESSION['login'] = true;
                        $data = $this->model->sessionLogin($_SESSION['iduser']);
                        $_SESSION['userData'] = $data;

                        $response = array('status' => true, 'msg' => 'Ok');
                    } else {
                        $response = array('status' => false, 'msg' => 'Usuario inactivo');
                    }
                }
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        exit();
    }
}
