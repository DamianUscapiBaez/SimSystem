<?php

class Roles extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location:' . base_url() . '/');
        }
        getPermisos(3);
    }

    public function Roles()
    {
        if (empty($_SESSION['permissionsMod']['statuspermissions'])) {
            header('Location:' . base_url() . '/Dashboard');
        }
        $data['page_id'] = 1;
        $data['page_tag'] = "roles";
        $data['page_title'] = "ROLES DE USUARIO";
        $data['page_name'] = "Roles";
        $data['page_descripcion'] = "Página de roles de usuario";
        $data['page_functions_js'] = "functions_roles.js";
        $this->views->getView($this, 'roles', $data);
    }

    public function getRoles()
    {
        $roles = $this->model->selectRoles();
        foreach ($roles as &$role) { // Usamos & para modificar el array original
            $role['statusrole'] = ($role['statusrole'] == 1) ? '<span class="status_btn_success">Activo</span>' : '<span class="status_btn_error">Inactivo</span>';
            $role['options'] = '<div class="text-center">';
            $role['options'] .= '<button class="action_btn mr_10 border-0" onclick="fntPermisos(\'' . $role['idrole'] . '\')" title="Permisos Rol"><i class="fa fa-key"></i></button>';
            $role['options'] .= '<button class="action_btn mr_10 border-0" onclick="fntEditRol(\'' . $role['idrole'] . '\')" title="Editar Rol"><i class="far fa-edit"></i></button>';
            $role['options'] .= '<button class="action_btn border-0" onclick="fntDelRol(\'' . $role['idrole'] . '\')" title="Eliminar Rol"><i class="fa fa-trash"></i></button>';
            $role['options'] .= '</div>';
        }
        echo json_encode($roles, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getSelectRoles()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectRoles();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['statusrole'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['idrole'] . '">' . $arrData[$i]['namerole'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }

    public function getRol($idrol)
    {
        $intIdrol = intval(strClean($idrol));
        if ($intIdrol > 0) {
            $arrData = $this->model->selectRol($intIdrol);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setRol()
    {
        $intIdrol = intval($_POST['idRol']);
        $strRol = strClean($_POST['txtNombre']);
        $strDescripcion = strClean($_POST['txtDescripcion']);
        $intStatus = intval($_POST['listStatus']);

        if ($intIdrol == 0) {
            //clear
            $request_rol = $this->model->insertRol($strRol, $strDescripcion, $intStatus);
            $option = 1;
        } else {
            $request_rol = $this->model->updateRol($intIdrol, $strRol, $strDescripcion, $intStatus);
            $option = 2;
        }

        if ($request_rol > 0) {
            if ($option == 1) {
                $arrResponse = array('status' => true, 'msg' => 'Datos Guardados con Exito.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados con Exito.');
            }
        } else if ($request_rol == 'exist') {
            $arrResponse = array('status' => false, 'msg' => '¡Atención! el Rol ya existe.');
        } else {
            $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar datos.');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delRol()
    {
        if ($_POST) {
            $intIdrol = intval($_POST['idrol']);
            //$requestDelete = $this->moldel->deleteRol($intIdrol);
            $requestDelete = $this->model->deleteRol($intIdrol);
            if ($requestDelete == "ok") {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
            } elseif ($requestDelete == "exist") {
                $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol asosiado a usuarios.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
