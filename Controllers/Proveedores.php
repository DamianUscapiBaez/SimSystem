<?php

class Proveedores extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location:' . base_url() . '/');
        }
        getPermisos(7);
    }

    public function Proveedores()
    {
        if (empty($_SESSION['permissionsMod']['statuspermissions'])) {
            header('Location:' . base_url() . '/Dashboard');
        }

        // Configuración de la página
        $data['page_tag'] = "Proveedores";
        $data['page_title'] = "PROVEEDORES";
        $data['page_name'] = "Proveedores";
        $data['page_descripcion'] = "Pagina de proveedores para productos";
        $data['page_functions_js'] = "functions_proveedores.js";

        // Renderizar la vista
        $this->views->getView($this, 'proveedores', $data);
    }
    public function getProveedores()
    {
        // Obtener datos de los proveedores
        $arrData = $this->model->selectProveedores();

        // Mapear tipos de documentos para una búsqueda rápida
        $mapTiposDocumento = [];
        foreach (tipodocumento() as $documento) {
            $mapTiposDocumento[$documento->codigo] = $documento->documento;
        }

        // Iterar sobre cada proveedor
        foreach ($arrData as $index => &$proveedor) {
            // Mapear el tipo de documento
            if (isset($mapTiposDocumento[$proveedor['typedocument']])) {
                $proveedor['typedocument'] = $mapTiposDocumento[$proveedor['typedocument']];
            }

            // Asignar valores predeterminados
            $proveedor['emailprovider'] = $proveedor['emailprovider'] ?? "N.A";
            $proveedor['phonenumber'] = $proveedor['phonenumber'] ?? "N.A";
            $proveedor['addressofprovider'] = $proveedor['addressofprovider'] ?? "N.A";

            // Actualizar el estado del proveedor
            $proveedor['statusprovider'] = ($proveedor['statusprovider'] == 1) ? '<span class="status_btn_success">Activo</span>' : '<span class="status_btn_error">Inactivo</span>';

            // Crear botones de acciones
            $btnView = '<button class="action_btn mr_10 border-0" onclick="fntViewProveedor(\'' . $proveedor['idprovider'] . '\')" title="Ver Proveedor"><i class="fa fa-eye"></i></button>';
            $btnEdit = '<button class="action_btn mr_10 border-0" onclick="fntEditProveedor(\'' . $proveedor['idprovider'] . '\')" title="Editar Proveedor"><i class="far fa-edit"></i></button>';
            $btnDelete = '<button class="action_btn border-0" onclick="fntDelProveedor(\'' . $proveedor['idprovider'] . '\')" title="Eliminar Proveedor"><i class="fas fa-trash"></i></button>';

            // Agregar opciones al proveedor
            $proveedor['options'] = '<div class="text-center">' . $btnView . $btnEdit . $btnDelete . '</div>';
        }

        // Enviar respuesta JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function getProveedor($idproveedor)
    {
        $idproveedor = intval($idproveedor);
        if ($idproveedor > 0) {
            $arrData = $this->model->selectProveedor($idproveedor);
            foreach (tipodocumento() as $documento) {
                if ($documento->codigo == $arrData['typedocument']) {
                    $arrData['tipodocumentoview'] = $documento->documento;
                    break;
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

    public function setProveedor()
    {
        if ($_POST) {
            if (empty($_POST['tipodocumento']) || empty($_POST['numerodocumento']) || empty($_POST['nombreproveedor']) || empty($_POST['statusproveedor'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos');
            } else {
                $idproveedor = intval($_POST['idproveedor']);
                $tipodocumento = $_POST['tipodocumento'];
                $numerodocumento = strClean($_POST['numerodocumento']);
                $nombreproveedor = strClean($_POST['nombreproveedor']);
                $correoproveedor = $_POST['correoproveedor'];
                $telefonoproveedor = $_POST['telefonoproveedor'];
                $direccionproveedor = $_POST['direccionproveedor'];
                $statusproveedor = intval($_POST['statusproveedor']);

                $request_proveedor = "";

                if ($idproveedor == 0) {
                    $request_proveedor = $this->model->insertProveedor($tipodocumento, $numerodocumento, $nombreproveedor, $correoproveedor, $telefonoproveedor, $direccionproveedor, $statusproveedor);
                    $option = 1;
                } else {
                    $request_proveedor = $this->model->updateProveedor($idproveedor, $tipodocumento, $numerodocumento, $nombreproveedor, $correoproveedor, $telefonoproveedor, $direccionproveedor, $statusproveedor);
                    $option = 2;
                }
                if ($request_proveedor > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos Guardados con Exito.', 'idproveedor' => $request_proveedor);
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados con Exito.');
                    }
                } else if ($request_proveedor == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el proveedor ya existe.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar datos.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delProveedor()
    {
        if ($_POST) {
            $intIdproveedor = intval($_POST['idproveedor']);
            $requestDelete = $this->model->deleteProveedor($intIdproveedor);
            if ($requestDelete == "ok") {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la proveedor');
            } elseif ($requestDelete == "exist") {
                $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar el proveedor asociado a productos');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el proveedor');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getSelectProveedores()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectProveedores();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['statusprovider'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['idprovider'] . '">' . $arrData[$i]['nameprovider'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }

    public function buscarproveedorinput($codigo)
    {
        $arrData = $this->model->buscarProveedorNumero($codigo);
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function buscarproveedor($search)
    {
        $arrData = $this->model->buscarProveedorNombreNumero($search);
        foreach ($arrData as &$proveedor) {
            foreach (tipodocumento() as $documento) {
                if ($documento->codigo == $proveedor['tipodocumento']) {
                    $proveedor['tipodocumento'] = $documento->documento;
                    break;
                }
            }
        }
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}
