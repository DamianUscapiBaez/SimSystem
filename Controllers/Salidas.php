<?php
class Salidas extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location:' . base_url() . '/');
        }
        getPermisos(10);
    }
    public function Salidas()
    {
        if (empty($_SESSION['permissionsMod']['statuspermissions'])) {
            header('Location:' . base_url() . '/Dashboard');
        }
        $data['page_id'] = 1;
        $data['page_tag'] = "Salidas";
        $data['page_title'] = "SALIDAS";
        $data['page_name'] = "Salidas de Productos";
        $data['page_content'] = "Pagina Salidas de productos";
        $data['page_descripcion'] = "Pagina de salidas de productos";
        $data['page_functions_js'] = "functions_salidas.js";
        $this->views->getView($this, 'salidas', $data);
    }

    public function historialSalidas()
    {
        $data['page_tag'] = "Historial de salidas";
        $data['page_title'] = "Historial de salidas";
        $data['page_name'] = "Historial de salidas";
        $data['page_descripcion'] = "Pagina de historial";
        $data['page_functions_js'] = "functions_historial_salidas.js";
        $this->views->getView($this, 'salidasLista', $data);
    }

    public function listaHoy()
    {
        $data['page_tag'] = "Historial de salidas de hoy";
        $data['page_title'] = "Historial de salidas de hoy";
        $data['page_name'] = "Historial de salidas de hoy";
        $data['page_descripcion'] = "Pagina de historial de hoy";
        $data['page_functions_js'] = "functions_hoy_salidas.js";
        $data['facturas'] = $this->model->getFacturas();
        $data['boletas'] = $this->model->getBoletas();
        $data['facturasA'] = $this->model->getFacturasAnulado();
        $data['boletasA'] = $this->model->getBoletasAnulado();
        $this->views->getView($this, 'listaHoy', $data);
    }
    public function listarProductos()
    {
        $idpersona = $_SESSION['id_usuario'];
        $id = 1;
        $arrData = $this->model->get_tmp_detalle($idpersona);
        for ($i = 0; $i < count($arrData); $i++) {
            $arrData[$i]['id'] = $id++;
            $arrData[$i]['options'] = '<button class="btn btn-danger" onclick="deleteDetalle(' . $arrData[$i]['dtmp_salida_id'] . ')" type="button"><i class="fa fa-trash"></i></button>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function agregar_producto()
    {
        if ($_POST) {
            if (empty($_POST['idproducto']) || empty($_POST['cantidad'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos	incorrectos');
            } else {
                $id = intval($_POST['idproducto']);
                $datos = $this->model->getProducto($id);
                $idproducto = $datos['idproducto'];
                $idpersona = $_SESSION['id_usuario'];
                $cantidad = $_POST['cantidad'];
                $precio = $datos['precio_venta'];
                $comprobar = $this->model->consultarDetalle($idproducto, $idpersona);
                if (empty($comprobar)) {
                    $subtotal = $precio * $cantidad;
                    if ($datos['stock'] >= $cantidad) {
                        $request_agregar = "";
                        $request_agregar = $this->model->registrarDetalle($idproducto, $idpersona, $cantidad, $precio, $subtotal);
                        if ($request_agregar == "ok") {
                            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        } else {
                            $arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron agregar.');
                        }
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'Stock no disponible ' . $datos['stock']);
                    }
                } else {
                    $request_actualizar = "";
                    $total_cantidad = $comprobar['cantidad'] + $cantidad;
                    $subtotal = $precio * $total_cantidad;
                    if ($datos['stock'] < $total_cantidad) {
                        $arrResponse = array('status' => false, 'msg' => 'Stock no disponible.');
                    } else {
                        $request_actualizar = $this->model->actualizarDetalle($idproducto, $idpersona, $total_cantidad, $subtotal);
                        if ($request_actualizar == "ok") {
                            $arrResponse = array('status' => true, 'msg' => 'Datos actualizo correctamente.');
                        } else {
                            $arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron actualizar.');
                        }
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function deleteDetalle($id_detalle)
    {
        $request_delete = $this->model->deleteDetalle($id_detalle);
        if ($request_delete == "ok") {
            $arrResponse = array('status' => true, 'msg' => 'Se elimino correctamente.');
        } else {
            $arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron eliminar.');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    public function registrarSalida()
    {
        $idusuario = $_SESSION['id_usuario'];
        $comprobar_tmp = $this->model->getDetalleTmp($idusuario);
        if ($comprobar_tmp) {
            $cliente = intval($_POST['idcliente']);
            if (!empty($cliente)) {
                $total = $this->model->getTotalDetalle($idusuario);
                $arrData_salida = $this->model->registrarSalida($idusuario, $cliente, floatval($total['total']));
                if ($arrData_salida == "ok") {
                    $detalle_productos = $this->model->get_tmp_detalle($idusuario);
                    $id_salida = $this->model->id_salida();
                    foreach ($detalle_productos as $row) {
                        $idproducto = $row['idproducto'];
                        $cantidad = $row['cantidad'];
                        $precio = $row['precio'];
                        $subTotal = $cantidad * $precio;
                        $this->model->registrar_detalle_salida($id_salida['idsalida'], $idproducto, $cantidad, $precio, $subTotal);
                        $stock_actual = $this->model->getProducto($idproducto);
                        $stock = $stock_actual['stock'] - $cantidad;
                        $this->model->actualizarStock($idproducto, $stock);
                        // registrar movimientos
                        $producto = $this->model->seleccionarProducto($idproducto);
                        $request_m = $this->model->registrarMovimientos($producto['nombre'], $stock, $cantidad);
                        foreach ($request_m as $rowm) {
                            $this->model->detalle_movimiento($rowm['idmovimiento'], $cantidad, $precio, $subTotal);
                        }
                    }
                    $response_vaciar = $this->model->vaciarDetalle($idusuario);
                    if ($response_vaciar == "ok") {
                        $arrResponse = array('status' => true, 'idsalida' => $id_salida['idsalida'], 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron agregar.');
                    }
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'error no se realizo la entrada.');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'nose ingreso ningun cliente');
            }
        } else {
            $arrResponse = array('status' => false, 'msg' => 'nose ingreso ningun producto');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getSalidas()
    {
        $arrData = $this->model->getHistorialSalida();
        for ($i = 0; $i < count($arrData); $i++) {
            $arrData[$i]['fecha_salida'] = $arrData[$i]['datecreated'] . ' ' . $arrData[$i]['timecreated'];
            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="badge badge-success">Completado</span>';
                $arrData[$i]['reporte'] = '<div class="text-center">
												<button type="button" class="btn btn-primary mr-2" onclick="generarFactura(' . $arrData[$i]['idsalida'] . ')"><i class="fas fa-file-pdf fa-fw"></i></button>
												<button class="btn btn-warning mr-2" onclick="btnAnular(' . $arrData[$i]['idsalida'] . ')"><i class="fas fa-ban"></i></button>
											</div>';
            } else {
                $arrData[$i]['status'] = '<span class="badge badge-danger">Anulado</span>';
                $arrData[$i]['reporte'] = '<div class="text-center">
				   								<button type="button" class="btn btn-primary mr-2" onclick="generarFactura(' . $arrData[$i]['idsalida'] . ')"><i class="fas fa-file-pdf fa-fw"></i></button>
											</div>';
            }
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getFacturahoy()
    {
        $arrData = $this->model->getFacturaSalidahoy();
        for ($i = 0; $i < count($arrData); $i++) {
            $id = 1;
            $arrData[$i]['id'] = $id;
            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="badge badge-success">Completado</span>';
                $arrData[$i]['reporte'] = '<div class="text-center">
													<button type="button" class="btn btn-success" onclick="generarFactura(' . $arrData[$i]['idsalida'] . ')"><i class="fas fa-file-pdf"></i></button>
													<button class="btn btn-warning" onclick="btnAnular(' . $arrData[$i]['idsalida'] . ')"><i class="fas fa-ban"></i></button>
												</div>';
            }
            if ($arrData[$i]['tipo_documento'] == 1) {
                $arrData[$i]['tipo_documento'] = '<p>Factura</p>';
            }
            $id++;
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getFacturahoyAnulados()
    {
        $arrData = $this->model->getFacturaSalidahoyAnulados();
        for ($i = 0; $i < count($arrData); $i++) {
            $id = 1;
            $arrData[$i]['id'] = $id;
            if ($arrData[$i]['status'] == 0) {
                $arrData[$i]['status'] = '<span class="badge badge-danger">Anulado</span>';
                $arrData[$i]['reporte'] = '<div class="text-center">
													<button type="button" class="btn btn-danger" onclick="generarFactura(' . $arrData[$i]['idsalida'] . ')"><i class="fas fa-file-pdf"></i></button>
												</div>';
            }
            if ($arrData[$i]['tipo_documento'] == 1) {
                $arrData[$i]['tipo_documento'] = '<p>Factura</p>';
            }
            $id++;
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getBoletashoy()
    {
        $arrData = $this->model->getBoletashoy();
        for ($i = 0; $i < count($arrData); $i++) {
            $id = 1;
            $arrData[$i]['id'] = $id;
            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="badge badge-success">Completado</span>';
                $arrData[$i]['reporte'] = '<div class="text-center">
													<button type="button" class="btn btn-success" onclick="generarBoleta(' . $arrData[$i]['idsalida'] . ')"><i class="fas fa-file-pdf"></i></button>
													<button class="btn btn-warning" onclick="btnAnular(' . $arrData[$i]['idsalida'] . ')"><i class="fas fa-ban"></i></button>
												</div>';
            }
            if ($arrData[$i]['tipo_documento'] == 2) {
                $arrData[$i]['tipo_documento'] = '<p>Boleta</p>';
            }
            $id++;
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getBoletasAnuladoshoy()
    {
        $arrData = $this->model->getBoletasAnuladoshoy();
        for ($i = 0; $i < count($arrData); $i++) {
            $id = 1;
            $arrData[$i]['id'] = $id;
            if ($arrData[$i]['status'] == 0) {
                $arrData[$i]['status'] = '<span class="badge badge-danger">Anulado</span>';
                $arrData[$i]['reporte'] = '<div class="text-center">
													<button type="button" class="btn btn-danger" onclick="generarBoleta(' . $arrData[$i]['idsalida'] . ')"><i class="fas fa-file-pdf"></i></button>
												</div>';
            }
            if ($arrData[$i]['tipo_documento'] == 2) {
                $arrData[$i]['tipo_documento'] = '<p>Boleta</p>';
            }
            $id++;
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generarReportePdf($id_salida)
    {
        $empresa = $this->model->getEmpresa();
        $datos_salida = $this->model->getSalida($id_salida);
        $productos = $this->model->getProSalida($id_salida);
        $cliente = $this->model->getClienteSalida($id_salida);

        if ($datos_salida['status'] == 0) {
            $datos_salida['status'] = 'Anulado';
        } else {
            $datos_salida['status'] = 'Completado';
        }
        if ($cliente['tipo_documento'] == 1) {
            $cliente['tipo_documento'] = 'RUC';
        } else {
            $cliente['tipo_documento'] = 'DNI';
        }
        if ($datos_salida) {
            include 'Assets/libs/php/FPDF/FPDF.php';
            $pdf = new FPDF('P', 'mm', array(80, 150)); // Tamaño tickt 80mm x 150 mm (largo aprox)
            $pdf->AddPage();
            // CABECERA
            $pdf->SetFont('Helvetica', '', 12);
            $pdf->Cell(60, 4, utf8_decode($empresa['nombre']), 0, 1, 'C');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(60, 4, utf8_decode($empresa['ruc']), 0, 1, 'C');
            $pdf->MultiCell(60, 4, utf8_decode($empresa['direccion']), 0, 'C');
            $pdf->Cell(60, 4, utf8_decode($empresa['telefono']), 0, 1, 'C');
            $pdf->Cell(60, 4, utf8_decode($empresa['correo']), 0, 1, 'C');
            // DATOS FACTURA
            $pdf->Ln(5);
            $pdf->Cell(60, 4, utf8_decode('N° Salida: 00' . $datos_salida['idsalida']), 0, 1, '');
            $pdf->Cell(60, 4, utf8_decode('Fecha: ' . $datos_salida['datecreated']), 0, 1, '');
            $pdf->Cell(60, 4, utf8_decode('Estado: ' . $datos_salida['status']), 0, 1, '');
            //DATOS DE CLIENTE
            $pdf->Ln(2);
            $pdf->Cell(60, 4, utf8_decode('Cliente: ' . $cliente['cliente']), 0, 1, '');
            $pdf->Cell(60, 4, utf8_decode('Tipo de documento: ' . $cliente['tipo_documento']), 0, 1, '');
            $pdf->Cell(60, 4, utf8_decode('Tipo de documento: ' . $cliente['documento']), 0, 1, '');
            // COLUMNAS
            $pdf->SetFont('Helvetica', 'B', 7);
            $pdf->Cell(25, 10, 'Articulo', 0);
            $pdf->Cell(5, 10, 'Ud', 0, 0, 'R');
            $pdf->Cell(10, 10, 'Precio', 0, 0, 'R');
            $pdf->Cell(16, 10, 'Subtotal', 0, 0, 'R');
            $pdf->Ln(8);
            $pdf->Cell(60, 0, '', 'T');
            $pdf->Ln(0);

            // PRODUCTOS
            foreach ($productos as $row) {
                $pdf->SetFont('Helvetica', '', 6);
                $pdf->MultiCell(25, 4, utf8_decode($row['nombre']), 0, 'L');
                $pdf->Cell(30, -5, $row['cantidad'], 0, 0, 'R');
                $pdf->Cell(10, -5, utf8_decode($row['precio_compra']), 0, 0, 'R');
                $pdf->Cell(15, -5, utf8_decode($row['subtotal']), 0, 0, 'R');
                $pdf->Ln(3);
            }
            // SUMATORIO DE LOS PRODUCTOS Y EL IVA
            $pdf->Cell(60, 0, '', 'T');
            $pdf->Ln(1);
            $pdf->Cell(25, 10, 'TOTAL', 0);
            $pdf->Cell(18, 10, '', 0);
            $pdf->Cell(15, 10, utf8_decode('s/.' . $datos_salida['total']), 0, 0, 'R');
            $pdf->Output();
        } else {
            header('location:' . base_url() . '/Error');
        }
    }
    public function anularSalida($id_salida)
    {
        $arrData = $this->model->getAnularSalida($id_salida);
        $response_anular = $this->model->getAnular($id_salida);
        foreach ($arrData as $row) {
            $stock_actual = $this->model->getProducto($row['productoid']);
            $stock = $stock_actual['stock'] + $row['cantidad'];
            $this->model->actualizarStock($row['productoid'], $stock);
            $producto = $this->model->seleccionarProducto($row['productoid']);
            // dep(" ".$producto['nombre']." ".$stock." ".$row['cantidad']);
            $request_m = $this->model->set_movimiento($producto['nombre'], $stock, $row['cantidad']);
            foreach ($request_m as $rowm) {
                $this->model->set_detalle_movimiento($rowm['idmovimiento'], $row['cantidad'], $producto['precio_compra'], $row['subtotal']);
            }
        }
        if ($response_anular == "ok") {
            $arrResponse = array('status' => true, 'msg' => 'Se ha anulado la salida');
        } else {
            $arrResponse = array('status' => false, 'msg' => 'Error al anular la salida');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function CalcularTotal()
    {
        $idpersona = $_SESSION['id_usuario'];
        $arrData = $this->model->getTotalDetalle($idpersona);
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarSalidas()
    {
        $fecha_desde = $_POST['date_desde'];
        $fecha_hasta = $_POST['date_hasta'];
        $arrData = $this->model->select_date_salidas($fecha_desde, $fecha_hasta);
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
}
