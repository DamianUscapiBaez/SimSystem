<?php
class Entradas extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location:' . base_url() . '/');
        }
        getPermisos(9);
    }
    public function Entradas()
    {
        if (empty($_SESSION['permissionsMod']['statuspermissions'])) {
            header('Location:' . base_url() . '/Dashboard');
        }
        $data['page_id'] = 1;
        $data['page_tag'] = "Entradas";
        $data['page_title'] = "ENTRADAS";
        $data['page_name'] = "Entradas de Productos";
        $data['page_content'] = "Pagina Entradas de productos";
        $data['page_descripcion'] = "Pagina de entradas de productos";
        $data['page_functions_js'] = "functions_entradas.js";
        $this->views->getView($this, 'entrada', $data);
    }
    public function listadoentradas()
    {
        $data['page_tag'] = "Historial de entradas";
        $data['page_title'] = "Historial de entradas";
        $data['page_name'] = "Historial de entradas";
        $data['page_descripcion'] = "Pagina de historial";
        $data['page_functions_js'] = "functions_historial_entradas.js";
        $this->views->getView($this, 'listadoentradas', $data);
    }
    // public function agregar_producto()
    // {
    //     if ($_POST) {
    //         if (empty($_POST['idproducto']) || empty($_POST['cantidad'])) {
    //             $arrResponse = array("status" => false, "msg" => 'Datos	incorrectos');
    //         } else {
    //             $id = intval($_POST['idproducto']);
    //             $datos = $this->model->getProducto($id);
    //             $idproducto = $datos['idproducto'];
    //             $idpersona = $_SESSION['id_usuario'];
    //             $cantidad = $_POST['cantidad'];
    //             $precio = $datos['precio_compra'];
    //             $comprobar = $this->model->consultarDetalle($idproducto, $idpersona);
    //             if (empty($comprobar)) {
    //                 $subTotal = $precio * $cantidad;
    //                 $request_agregar = "";
    //                 $request_agregar = $this->model->registrarDetalle($idproducto, $idpersona, $cantidad, $precio, $subTotal);
    //                 if ($request_agregar == "ok") {
    //                     $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
    //                 } else {
    //                     $arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron agregar.');
    //                 }
    //             } else {
    //                 $request_actualizar = "";
    //                 $total_cantidad = $comprobar['cantidad'] + $cantidad;
    //                 $subTotal = $precio * $total_cantidad;
    //                 $request_actualizar = $this->model->actualizarDetalle($idproducto, $idpersona, $total_cantidad, $subTotal);
    //                 if ($request_actualizar == "ok") {
    //                     $arrResponse = array('status' => true, 'msg' => 'Datos actualizo correctamente.');
    //                 } else {
    //                     $arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron actualizar.');
    //                 }
    //             }
    //             echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    //         }
    //     }
    //     die();
    // }
    // public function listarProductos()
    // {
    //     $idpersona = $_SESSION['id_usuario'];
    //     $arrData = $this->model->get_tmp_detalle($idpersona);
    //     $id = 1;
    //     for ($i = 0; $i < count($arrData); $i++) {
    //         $arrData[$i]['id'] = $id++;
    //         $arrData[$i]['options'] = '<button class="btn btn-danger" onclick="deleteDetalle(' . $arrData[$i]['dtmp_entrada_id'] . ')" type="button"><i class="fa fa-trash"></i></button>';
    //     }
    //     echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    //     die();
    // }
    // public function CalcularTotal()
    // {
    //     $idpersona = $_SESSION['id_usuario'];
    //     $arrData = $this->model->getTotalDetalle($idpersona);
    //     echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    //     die();
    // }
    // public function deleteDetalle($id_detalle)
    // {
    //     $request_delete = $this->model->deleteDetalle($id_detalle);
    //     if ($request_delete == "ok") {
    //         $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
    //     } else {
    //         $arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron agregar.');
    //     }
    //     echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    // }
    public function setEntrada()
    {
        if ($_POST) {
            if (empty($_POST['fechaemision'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $identrada = intval($_POST['identrada']);
                $idusuario = $_SESSION['id_usuario'];
                $idproveedor = intval($_POST['idproveedor']);
                $fechaemision = $_POST['fechaemision'];
                $tipoentrada = strClean($_POST['tipoentrada']);
                $tipodocumento = strClean($_POST['tipodocumento']);
                $numerodocumento = strClean($_POST['numerodicumento']);
                $detalle = strClean($_POST['detalle']);
                $total = intval($_POST['total']);
                $statusentrada = strClean($_POST['statusentrada']);

                $request_entrada = "";

                if ($identrada == 0) {
                    $request_entrada = $this->model->insertEntrada($identrada, $idusuario, $idproveedor, $fechaemision, $tipoentrada, $tipodocumento, $numerodocumento, $detalle, $total, $statusentrada);
                    $option = 1;
                } else {
                    $request_entrada = $this->model->updateProveedor();
                    $option = 2;
                }
                if ($request_entrada > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos Guardados con Exito.', 'idproveedor' => $request_entrada);
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados con Exito.');
                    }
                } else if ($request_entrada == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el proveedor ya existe.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getEntradas()
    {
        $arrData = $this->model->getHistorialEntrada();
        foreach ($arrData as &$entradas) {
            foreach (tipodocumentosalida() as $documento) {
                if ($documento->codigo == $entradas['typedocument']) {
                    $entradas['typedocument'] = $documento->documento;
                    break;
                }
            }
            if (!isset($entradas['documentnumber'])) {
                $entradas['documentnumber'] = 'Documento no encontrado';
            }

            $opciones = '';
            if ($entradas['statusmovements'] == 1) {
                $opciones = '<div class="text-center">
                                <button class="btn btn-info mr-2" onclick="viewDetalle(' . $entradas['idmovements'] . ')"><i class="fas fa-eye text-white"></i></button>
                                <button data-toggle="tooltip" title="GENERAR PDF" type="button" class="btn btn-primary mr-2" onclick="generarFactura(' . $entradas['idmovements'] . ')"><i class="fas fa-file-pdf"></i></button>
                                <button class="btn btn-warning mr-2" onclick="btnAnular(' . $entradas['idmovements'] . ')"><i class="fas fa-ban text-white"></i></button>
                            </div>';
            } else {
                $opciones = '<div class="text-center">
                                <button data-toggle="tooltip" title="GENERAR PDF" type="button" class="btn btn-primary mr-2" onclick="generarFactura(' . $entradas['idmovements'] . ')"><i class="fas fa-file-invoice-dollar"></i></button>
                            </div>';
            }

            $entradas['statusmovements'] = $entradas['statusmovements'] == 1 ? '<span class="status_btn_success">completado</span>' : '<span class="status_btn_error">Anulado</span>';

            $entradas['options'] = $opciones;
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    // public function getProducto($idproducto)
    // {
    //     $intIdproducto = intval(strClean($idproducto));
    //     if ($intIdproducto > 0) {
    //         $arrData = $this->model->selectProducto($intIdproducto);
    //         if (empty($arrData)) {
    //             $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
    //         } else {
    //             $arrResponse = array('status' => true, 'data' => $arrData);
    //         }
    //         echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    //     }
    //     die();
    // }
    // public function generarFacturaPdf($id_entrada)
    // {
    //     $empresa = $this->model->getEmpresa();
    //     $datos_entrada = $this->model->getEntrada($id_entrada);
    //     $productos = $this->model->getProEntrada($id_entrada);
    //     $proveedor = $this->model->getProveedorEntrada($id_entrada);

    //     if ($datos_entrada) {
    //         if ($datos_entrada['status'] == 0) {
    //             $datos_entrada['status'] = 'Anulado';
    //         } else {
    //             $datos_entrada['status'] = 'Completado';
    //         }
    //         include 'Assets/libs/php/FPDF/FPDF.php';
    //         $pdf = new FPDF('P', 'mm', array(80, 150)); // Tamaño tickt 80mm x 150 mm (largo aprox)
    //         $pdf->AddPage();
    //         // CABECERA
    //         $pdf->SetFont('Helvetica', '', 12);
    //         $pdf->Cell(60, 4, utf8_decode($proveedor['proveedor']), 0, 1, 'C');
    //         $pdf->SetFont('Helvetica', '', 8);
    //         $pdf->Cell(60, 4, utf8_decode($proveedor['ruc']), 0, 1, 'C');
    //         $pdf->MultiCell(60, 4, utf8_decode($proveedor['direccion']), 0, 'C');
    //         $pdf->Cell(60, 4, utf8_decode($proveedor['telefono']), 0, 1, 'C');
    //         $pdf->Cell(60, 4, utf8_decode($proveedor['correo']), 0, 1, 'C');
    //         // DATOS FACTURA
    //         $pdf->Ln(5);
    //         $pdf->Cell(60, 4, utf8_decode('N° Entrada: 00' . $datos_entrada['identrada']), 0, 1, '');
    //         $pdf->Cell(60, 4, utf8_decode('Fecha: ' . $datos_entrada['datecreated']), 0, 1, '');
    //         $pdf->Cell(60, 4, utf8_decode('Estado: ' . $datos_entrada['status']), 0, 1, '');
    //         //DATOS DE CLIENTE
    //         $pdf->Ln(2);
    //         $pdf->Cell(60, 4, utf8_decode('Cliente: ' . $empresa['nombre']), 0, 1, '');
    //         $pdf->Cell(60, 4, utf8_decode('Ruc: ' . $empresa['ruc']), 0, 1, '');
    //         // COLUMNAS
    //         $pdf->SetFont('Helvetica', 'B', 7);
    //         $pdf->Cell(25, 10, 'Articulo', 0);
    //         $pdf->Cell(5, 10, 'Ud', 0, 0, 'R');
    //         $pdf->Cell(10, 10, 'Precio', 0, 0, 'R');
    //         $pdf->Cell(16, 10, 'Subtotal', 0, 0, 'R');
    //         $pdf->Ln(8);
    //         $pdf->Cell(60, 0, '', 'T');
    //         $pdf->Ln(0);

    //         // PRODUCTOS
    //         foreach ($productos as $row) {
    //             $pdf->SetFont('Helvetica', '', 6);
    //             $pdf->MultiCell(25, 4, utf8_decode($row['nombre']), 0, 'L');
    //             $pdf->Cell(30, -5, $row['cantidad'], 0, 0, 'R');
    //             $pdf->Cell(10, -5, utf8_decode($row['precio_compra']), 0, 0, 'R');
    //             $pdf->Cell(15, -5, utf8_decode($row['subtotal']), 0, 0, 'R');
    //             $pdf->Ln(3);
    //         }
    //         // SUMATORIO DE LOS PRODUCTOS Y EL IVA
    //         $pdf->Cell(60, 0, '', 'T');
    //         $pdf->Ln(1);
    //         $pdf->Cell(25, 10, 'TOTAL', 0);
    //         $pdf->Cell(18, 10, '', 0);
    //         $pdf->Cell(15, 10, utf8_decode('s/.' . $datos_entrada['total']), 0, 0, 'R');
    //         $pdf->Output();
    //     } else {
    //         header('location:' . base_url() . '/Error');
    //     }
    // }

    // public function anularEntrada($id_entrada)
    // {
    //     $arrData = $this->model->getAnularEntrada($id_entrada);
    //     $response_anular = $this->model->getAnular($id_entrada);
    //     foreach ($arrData as $row) {
    //         $stock_actual = $this->model->getProducto($row['productoid']);
    //         $stock = $stock_actual['stock'] - $row['cantidad'];
    //         $this->model->actualizarStock($row['productoid'], $stock);
    //         $producto = $this->model->seleccionarProducto($row['productoid']);
    //         $cantidad = $row['cantidad'];
    //         $precio = $producto['precio_compra'];
    //         $subTotal = $cantidad * $precio;
    //         $request_m = $this->model->set_movimiento($producto['nombre'], $stock, $row['cantidad']);
    //         foreach ($request_m as $rowm) {
    //             $this->model->set_detalle_movimiento($rowm['idmovimiento'], $row['cantidad'], $producto['precio_compra'], $subTotal);
    //         }
    //     }
    //     if ($response_anular == "ok") {
    //         $arrResponse = array('status' => true, 'msg' => 'Se ha anulado la entrada');
    //     } else {
    //         $arrResponse = array('status' => false, 'msg' => 'Error al anular la entrada');
    //     }
    //     echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    //     die();
    // }
}
