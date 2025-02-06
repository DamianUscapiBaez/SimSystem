<?php

class Usuarios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location:' . base_url() . '/');
        }
        getPermisos(4);
    }

    public function Usuarios()
    {
        if (empty($_SESSION['permissionsMod']['statuspermissions'])) {
            header('Location:' . base_url() . '/Dashboard');
        }
        $data['page_tag'] = "usuarios";
        $data['page_title'] = "USUARIOS";
        $data['page_name'] = "usuarios";
        $data['page_descripcion'] = "Pagina de usuario";
        $data['page_functions_js'] = "functions_usuarios.js";
        $this->views->getView($this, 'usuarios', $data);
    }

    public function setUsuario()
    {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_POST['txtEmail'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {

                $idUsuario = intval($_POST['idUsuario']);
                $srtNombre = ucwords(strClean($_POST['txtNombre']));
                $srtEmail = strtolower(strClean($_POST['txtEmail']));
                if ($idUsuario == 0) {
                    $option = 1;
                    $srtUsername = ucwords(strClean($_POST['txtUsername']));
                    $intTipoId = intval(strClean($_POST['listRolid']));
                    $srtStatus = intval(strClean($_POST['listStatus']));
                    $strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtPassword']);
                    $request_user = $this->model->insertUsuario($srtUsername, $srtNombre, $srtEmail, $strPassword, $intTipoId, $srtStatus);
                } else {
                    $option = 2;
                    if ($idUsuario == 1) {
                        $srtUsername = "";
                        $intTipoId = 0;
                        $srtStatus = 0;
                        $strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);
                        $request_user = $this->model->updateUsuario($idUsuario, $srtUsername, $srtNombre, $srtEmail, $strPassword, $intTipoId, $srtStatus);
                    } else {
                        $srtUsername = ucwords(strClean($_POST['txtUsername']));
                        $intTipoId = intval(strClean($_POST['listRolid']));
                        $srtStatus = intval(strClean($_POST['listStatus']));
                        $strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);
                        $request_user = $this->model->updateUsuario($idUsuario, $srtUsername, $srtNombre, $srtEmail, $strPassword, $intTipoId, $srtStatus);
                    }
                }
                if ($request_user > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                    }
                } else if ($request_user == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getUsuarios()
    {
        $users = $this->model->selectUsuarios();
        foreach ($users as &$user) {
            $user['statususer'] = $user['statususer'] == 1 ? '<span class="status_btn_success">Activo</span>' : '<span class="status_btn_error">Inactivo</span>';

            $btnView = '<button class="action_btn mr_10 border-0" onclick="fntViewUsuario(' . $user['iduser'] . ')" title="Ver Usuario"><i class="fa fa-eye"></i></button>';
            $btnEdit = '<button class="action_btn mr_10 border-0" onclick="fntEditUsuario(' . $user['iduser'] . ')" title="Editar Usuario"><i class="far fa-edit"></i></button>';

            $btnDelete = '<button class="action_btn border-0" onclick="fntDelUsuario(' . $user['iduser'] . ')" title="Eliminar Usuario"><i class="fa fa-trash"></i></button>';

            $user['options'] = '<div class="text-center">' . $btnView . '' . $btnEdit . '' . $btnDelete . '</div>';
        }

        echo json_encode($users, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getUsuario(int $idpersona)
    {
        $idusuario = intval($idpersona);
        if ($idusuario > 0) {
            $arrData = $this->model->selectUsuario($idusuario);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delUsuario()
    {
        if ($_POST) {
            $intIdpersona = intval($_POST['idUsuario']);
            $requestDelete = $this->model->deleteUsuario($intIdpersona);
            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
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
        $this->views->getView($this, 'perfil', $data);
    }

    public function putPerfil()
    {
        if ($_POST) {
            if (empty($_POST['txtUsername']) || empty($_POST['txtNombre'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idUsuario = $_SESSION['id_usuario'];
                $srtUsername = strClean($_POST['txtUsername']);
                $strNombre = strClean($_POST['txtNombre']);
                $strPassword = "";
                if (!empty($_POST['txtPassword'])) {
                    $strPassword = hash("SHA256", $_POST['txtPassword']);
                }
                $request_user = $this->model->updatePerfil($idUsuario,
                    $srtUsername,
                    $strNombre,
                    $strPassword);
                if ($request_user) {
                    sessionUser($idUsuario);
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}

?>