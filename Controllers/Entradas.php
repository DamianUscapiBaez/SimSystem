<?php
	class Entradas extends Controller{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('location:'.base_url().'/');
			}
			getPermisos(9);
		}
		public function Entradas(){
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Dashboard');
			}
		 	$data['page_id'] = 1;
			$data['page_tag'] = "Entradas";
			$data['page_title'] = "Entradas";
			$data['page_name'] = "Entradas de Productos";
			$data['page_content'] = "Pagina Entradas de productos";
            $data['page_descripcion'] = "Pagina de entradas de productos";
			$data['page_functions_js'] = "functions_entradas.js";
		 	$this->views->getView($this,'entradas',$data);
		}
		public function historialEntradas(){
			$data['page_tag'] = "Historial de entradas";
			$data['page_title'] = "Historial de entradas";
			$data['page_name'] = "Historial de entradas";
           	$data['page_descripcion'] = "Pagina de historial";
			$data['page_functions_js'] = "functions_historial_entradas.js";
		 	$this->views->getView($this,'entradasLista',$data);
		}

		public function buscarCodigo($codigo){
			$arrData = $this->model->getProCod($codigo);
			if ($arrData) {
				$arrResponse = array('status' => true, 'data' => $arrData);
			} else {
				$arrResponse = array('status' => false, 'msg' => 'Producto no existe o esta inactivo');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function searchProveedor($search){
			$arrData = $this->model->NombreProveedor($search);
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function buscar_producto($codigo){
			$arrData = $this->model->buscarProducto($codigo);
			if (empty($arrData)) {
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
			} else {
				$arrResponse = array('status' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
		public function agregar_producto(){
			if($_POST){
                if(empty($_POST['idproducto']) || empty($_POST['cantidad'])){
                    $arrResponse = array("status" => false, "msg" => 'Datos	incorrectos');
                }else{
                    $id = intval($_POST['idproducto']);
                    $datos = $this->model->getProducto($id);
                    $idproducto = $datos['idproducto'];
                    $idpersona = $_SESSION['id_usuario'];
                    $cantidad = $_POST['cantidad'];
					$precio = $datos['precio_compra'];
                    $comprobar = $this->model->consultarDetalle($idproducto,$idpersona);
                    if(empty($comprobar)){
						$subTotal = $precio * $cantidad;
                        $request_agregar = "";
                        $request_agregar = $this->model->registrarDetalle($idproducto,$idpersona,$cantidad,$precio,$subTotal);
                        if($request_agregar == "ok"){
                            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        }else{
                            $arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron agregar.');
                        }
                    }else{
                        $request_actualizar = "";
                        $total_cantidad = $comprobar['cantidad'] + $cantidad;
						$subTotal = $precio * $total_cantidad;
                        $request_actualizar = $this->model->actualizarDetalle($idproducto,$idpersona,$total_cantidad,$subTotal);
                        if($request_actualizar == "ok"){
                            $arrResponse = array('status' => true, 'msg' => 'Datos actualizo correctamente.');
                        }else{
                            $arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron actualizar.');
                        }
                    }
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }

		public function listarProductos(){
			$idpersona = $_SESSION['id_usuario'];
			$arrData= $this->model->get_tmp_detalle($idpersona);
			$id=1;
			for ($i = 0; $i < count($arrData); $i++) {
				$arrData[$i]['id'] = $id++;
				$arrData[$i]['options'] ='<button class="btn btn-danger" onclick="deleteDetalle('.$arrData[$i]['dtmp_entrada_id'].')" type="button"><i class="fa fa-trash"></i></button>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function CalcularTotal(){
			$idpersona = $_SESSION['id_usuario'];
			$arrData = $this->model->getTotalDetalle($idpersona);
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}
		public function deleteDetalle($id_detalle){
			$request_delete = $this->model->deleteDetalle($id_detalle);
			if($request_delete == "ok"){
				$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
			}else{
				$arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron agregar.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		
		public function registrarEntrada(){
			$idusuario = $_SESSION['id_usuario'];
			$comprobar_tmp = $this->model->getDetalleTmp($idusuario);
			if($comprobar_tmp){
				$proveedor = intval($_POST['idproveedor']);
				if(!empty($proveedor)){
					$total = $this->model->getTotalDetalle($idusuario);
					$arrData_entrada = $this->model->registrarEntrada($idusuario,$proveedor,floatval($total['total']));
					if($arrData_entrada == "ok"){
						$detalle_productos = $this->model->get_tmp_detalle($idusuario);
						$id_entrada = $this->model->id_entrada();
						foreach($detalle_productos as $row){
							$idproducto = $row['idproducto'];
							$cantidad = $row['cantidad'];
							$precio = $row['precio'];
							$subTotal = $cantidad * $precio;
							$this->model->registrar_detalle_entrada($id_entrada['identrada'],$idproducto,$cantidad,$precio,$subTotal);
							$stock_actual = $this->model->getProducto($idproducto);
							$stock = $stock_actual['stock'] + $cantidad; 
							$this->model->actualizarStock($idproducto,$stock);
							// registrar kardex producto
							$producto = $this->model->seleccionarProducto($idproducto);
							$request_m = $this->model->registrarMovimientos($producto['nombre'],$stock,$cantidad);
							foreach($request_m as $rowm){
								$this->model->detalle_movimiento($rowm['idmovimiento'],$cantidad,$precio,$subTotal);
							}
						} 
						$response_vaciar = $this->model->vaciarDetalle($idusuario);
						if($response_vaciar == "ok"){
							$arrResponse = array('status' => true,  'identrada' => $id_entrada['identrada'],'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'Los datos nose pudieron agregar.');
						}
					}else{
						$arrResponse = array('status' => false, 'msg' => 'error no se realizo la entrada.');
					}
				}else{
					$arrResponse = array('status' => false, 'msg' => 'no se ingreso ningun proveedor');
				}
			}else{
				$arrResponse = array('status' => false, 'msg' => 'nose ingreso ningun producto');
			}
			
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
		public function getEntradas(){
			$arrData = $this->model->getHistorialEntrada();
			for ($i = 0; $i < count($arrData); $i++) {
				$arrData[$i]['fecha_entrada'] = $arrData[$i]['datecreated'].' '.$arrData[$i]['timecreated'];
				if ($arrData[$i]['status'] == 1) {
					$arrData[$i]['status'] = '<span class="badge badge-success">Completado</span>';
					$arrData[$i]['reporte'] ='<div class="text-center">
												<button data-toggle="tooltip" title="FACTURA" type="button" class="btn btn-primary mr-2" onclick="generarFactura('.$arrData[$i]['identrada'].')"><i class="fas fa-file-pdf"></i></button>
												<button class="btn btn-warning mr-2" onclick="btnAnular('.$arrData[$i]['identrada'].')"><i class="fas fa-ban"></i></button>
											</div>';
				} else {
				   $arrData[$i]['status'] = '<span class="badge badge-danger">Anulado</span>';
				   $arrData[$i]['reporte'] ='<div class="text-center">
				   								<button data-toggle="tooltip" title="FACTURA" type="button" class="btn btn-primary mr-2" onclick="generarFactura('.$arrData[$i]['identrada'].')"><i class="fas fa-file-invoice-dollar"></i></button>
									  		</div>';
				}
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getProducto($idproducto){
			$intIdproducto = intval(strClean($idproducto));
			if ($intIdproducto > 0) {
				$arrData = $this->model->selectProducto($intIdproducto);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function generarFacturaPdf($id_entrada){
			$empresa = $this->model->getEmpresa();
			$datos_entrada = $this->model->getEntrada($id_entrada);
			$productos = $this->model->getProEntrada($id_entrada);
			$proveedor = $this->model->getProveedorEntrada($id_entrada);

			if($datos_entrada){
				if($datos_entrada['status']==0){
					$datos_entrada['status']='Anulado';
				}else{
					$datos_entrada['status']='Completado';
				}

				include 'Assets/libs/php/FPDF/FPDF.php';
				$pdf = new FPDF('P','mm',array(80,150));
				$pdf->AddPage();
				$pdf->SetMargins(10,0,0);
				$pdf->SetTitle('reporte de entrada');
				$pdf->SetFont('Arial','B',25);

				$pdf->SetFont('Helvetica','',12);
				$pdf->Cell(60,4,utf8_decode($proveedor['proveedor']),0,1,'C');
				$pdf->SetFont('Helvetica','',8);
				$pdf->Cell(60,4,'RUC: '.$proveedor['ruc'],0,1,'C');
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(60,4,utf8_decode($proveedor['direccion']),0,1,'C');
				$pdf->Cell(60,4,$proveedor['telefono'],0,1,'C');

				
				//factura
				$pdf->Ln(5);
				$pdf->SetX(3);		
				$pdf->Cell(60,4,'Entrada: '.utf8_decode('000'.$datos_entrada['identrada']),0,1,'');
				$pdf->SetX(3);	
				$pdf->Cell(60,4,'Fecha: '.$datos_entrada['datecreated'],0,1,'');
				$pdf->SetX(3);	
				$pdf->Cell(60,4,'Estado: '.$datos_entrada['status'],0,1,'');


				$pdf->Ln(2);
				$pdf->SetX(3);	
				$pdf->Cell(3,4,'Cliente: '.$empresa['nombre'],0,1,'L');
				$pdf->SetX(3);	
				$pdf->Cell(3,4,'Tipo de documento: RUC',0,1,'L');
				$pdf->SetX(3);	
				$pdf->Cell(3,4,'Documento: '.utf8_decode($empresa['ruc']),0,1,'L');
				

				// COLUMNAS
				$pdf->Ln(3);
				$pdf->SetFont('Helvetica', 'B', 7);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);

				$pdf->SetX(3);
				$pdf->Cell(10,8,'Ud',1,0,'L',true);
				$pdf->Cell(15,8,'Precio',1,0,'L',true);
				$pdf->Cell(15,8,'Subtotal',1,0,'L',true);
				$pdf->Cell(35,8,'Articulo',1,1,'L',true);
				$pdf->SetX(3);
				$pdf->Cell(73,0,'','T');
				$pdf->Ln(0);
				
				foreach($productos as $row){
					$pdf->SetX(3);
					$pdf->SetFont('Arial','',7);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFillColor(255,255,255);
					$pdf->Cell(10,7,$row['cantidad'],0,'L');
					$pdf->Cell(15,7,utf8_decode($row['precio_compra']),0,'L');
					$pdf->Cell(15,7,utf8_decode($row['subtotal']),0,'L');
					$pdf->MultiCell(35,7,utf8_decode($row['nombre']),0,'L');
					$pdf->SetX(4);
					$pdf->Cell(73,0,'','T');
				}
				$pdf->SetX(43);
				$pdf->Cell(35,8,utf8_decode('Total: '.$datos_entrada['total']),1,0);
				$pdf->Output();
			}else{
				header('location:'.base_url().'/Error');
			}
		}

		public function anularEntrada($id_entrada){
			$arrData = $this->model->getAnularEntrada($id_entrada);
			$response_anular = $this->model->getAnular($id_entrada);
			foreach($arrData as $row){
				$stock_actual = $this->model->getProducto($row['productoid']);
				$stock = $stock_actual['stock'] - $row['cantidad'];
				$this->model->actualizarStock($row['productoid'],$stock);
				$producto = $this->model->seleccionarProducto($row['productoid']);
				// dep(" ".$producto['nombre']." ".$stock." ".$row['cantidad']);
				$subTotal = $row['cantidad'] * $producto['precio_venta'];
				$request_m = $this->model->set_movimiento($producto['nombre'],$stock,$row['cantidad']);
				foreach($request_m as $rowm){
					$this->model->set_detalle_movimiento($rowm['idmovimiento'],$row['cantidad'],$producto['precio_venta'],$subTotal);
				}
			}
			if ($response_anular == "ok") {
				$arrResponse = array('status' => true, 'msg' => 'Se ha anulado la entrada');
			}else {
				$arrResponse = array('status' => false, 'msg' => 'Error al anular la entrada');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
	}
?>