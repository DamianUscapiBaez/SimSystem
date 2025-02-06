<?php
class Clientes extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location:' . base_url() . '/');
        }
        getPermisos(8);
    }
    public function Clientes()
    {
        if (empty($_SESSION['permissionsMod']['statuspermissions'])) {
            header('Location:' . base_url() . '/Dashboard');
        }
        $data['page_tag'] = "Clientes";
        $data['page_title'] = "CLIENTES";
        $data['page_name'] = "clientes";
        $data['page_descripcion'] = "Pagina de clientes";
        $data['page_functions_js'] = "functions_clientes.js";
        $this->views->getView($this, 'clientes', $data);
    }
    public function getClientes()
    {
        $arrData = $this->model->selectClientes();
    
        foreach ($arrData as &$cliente) {
            foreach (tipodocumento() as $documento) {
                if ($documento->codigo == $cliente['typedocument']) {
                    $cliente['typedocument'] = $documento->documento;
                    break;
                }
            }
            $cliente['phonenumber'] = $cliente['phonenumber'] ?? "N.A";
            $cliente['addressofclient'] = $cliente['addressofclient'] ?? "N.A";
            $cliente['statusclient'] = ($cliente['statusclient'] == 1) ? '<span class="status_btn_success">Activo</span>' : '<span class="status_btn_error">Inactivo</span>';
    
            $btnView = '<button class="action_btn mr_10 border-0" onclick="fntViewCliente(' . $cliente['idclient'] . ')" title="Ver Cliente"><i class="fa fa-eye"></i></button>';
            $btnEdit = '<button class="action_btn mr_10 border-0" onclick="fntEditCliente(' . $cliente['idclient'] . ')" title="Editar Cliente"><i class="far fa-edit"></i></button>';
            $btnDele = '<button class="action_btn border-0" onclick="fntDelCliente(' . $cliente['idclient'] . ')" title="Eliminar Cliente"><i class="fa fa-trash"></i></button>';
    
            $cliente['options'] = '<div class="text-center">' . $btnView . $btnEdit . $btnDele . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }
    

    public function setCliente()
    {
        if ($_POST) {
            if (empty($_POST['tipodocumento']) || empty($_POST['numerodocumento']) || empty($_POST['nombrecliente'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos');
            } else {
                $idcliente = intval($_POST['idcliente']);
                $tipodocumento = strClean($_POST['tipodocumento']);
                $numerodocumento = strClean($_POST['numerodocumento']);
                $nombrecliente = strClean($_POST['nombrecliente']);
                $direccioncliente = strClean($_POST['direccioncliente']);
                $telefonocliente = intval($_POST['telefonocliente']);
                $statuscliente = intval($_POST['statuscliente']);

                if ($idcliente == 0) {
                    $option = 1;
                    $request_cliente = $this->model->insertCliente($tipodocumento, $numerodocumento, $nombrecliente, $direccioncliente, $telefonocliente, $statuscliente);
                } else {
                    $option = 2;
                    $request_cliente = $this->model->updateCliente($idcliente, $tipodocumento, $numerodocumento, $nombrecliente, $direccioncliente, $telefonocliente, $statuscliente);
                }
                if ($request_cliente > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.', 'id' => $request_cliente);
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                    }
                } else if ($request_cliente == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el documento ingresado ya existe, ingrese otro.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCliente($idcliente)
    {
        $idcliente = intval(strClean($idcliente));
        if ($idcliente > 0) {
            $arrData = $this->model->selectCliente($idcliente);
            foreach (tipodocumento() as $documento) {
                if ($documento->codigo == $arrData['typedocument']) {
                    $arrData['tipodocumentoview'] = $documento->documento;
                    break; // Salir del bucle una vez que se ha encontrado la coincidencia
                }
            }
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delCliente()
    {
        if ($_POST) {
            $idcliente = intval($_POST['idcliente']);
            $requestDelete = $this->model->deleteCliente($idcliente);
            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cliente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cliente.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function buscarCliente($documento)
    {
        $intDocumento = strClean($documento);
        $arrData = $this->model->buscar_cliente($intDocumento);
        if ($arrData) {
            $arrResponse = array('status' => true, 'data' => $arrData);
        } else {
            $arrResponse = array('status' => false, 'msg' => 'Los datos del cliente no encontrados o se encuenta inactivo');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function buscar_cliente($cliente)
    {
        $arrData = $this->model->buscarCliente($cliente);
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}
