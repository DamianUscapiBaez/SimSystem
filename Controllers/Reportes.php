<?php
	require 'Assets/libs/php/FPDF/FPDF.php';
	class Reportes extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('location:'.base_url().'/');
			}
			getPermisos(11);
		}
		public function Stock_Minimo(){
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Dashboard');
			}
			$data['page_tag'] = "Reportes";
			$data['page_title'] = "Reporte de Stock Minimo de Productos";
			$data['page_name'] = "Reporte de Stock Minimo";
			$data['page_descripcion'] = "Reportes de stock minimo";
            $data['page_functions_js'] = "functions_reportes.js";
		 	$this->views->getView($this,'stock_minimo',$data);
		}
		public function Entradas_fechas(){
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Dashboard');
			}
			$data['page_tag'] = "Reportes Entradas";
			$data['page_title'] = "Reportes Entradas";
			$data['page_name'] = "Reporte de Stock Minimo";
			$data['page_descripcion'] = "Reportes Entradas de Productos por fechas";
            $data['page_functions_js'] = "functions_fechas_entradas.js";
		 	$this->views->getView($this,'entradas_fechas',$data);
		}
		public function Salidas_fechas(){
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Dashboard');
			}
			$data['page_tag'] = "Reportes Salidas";
			$data['page_title'] = "Reporte de Salidas";
			$data['page_name'] = "Reporte de Salidas por fechas";
			$data['page_descripcion'] = "Reportes de stock minimo";
            $data['page_functions_js'] = "functions_fechas_salidas.js";
		 	$this->views->getView($this,'salidas_fechas',$data);
		}
		public function Kardex(){
			if(empty($_SESSION['permisosMod']['status'])){
				header('Location:'.base_url().'/Dashboard');
			}
			$data['page_tag'] = "Kardex";
			$data['page_title'] = "KARDEX DE PRODUCTOS";
			$data['page_name'] = "Kardex";
			$data['page_descripcion'] = "Kardex de productos";
            $data['page_functions_js'] = "functions_kardex.js";
		 	$this->views->getView($this,'kardex',$data);
		}
		public function reporteStock(){
			$arrData = $this->model->getStockMinimo();
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function validar_fechas(){
			if($_POST){
				if(empty($_POST['date_from']) || empty($_POST['date_to'])){
					$arrResponse = array('status' => false, 'msg' => 'los campos no pueden ir vacios');
				}else{
					$fecha_from = $_POST['date_from'];
					$fecha_to = $_POST['date_to'];
					if($fecha_from<=$fecha_to){
						$arrResponse = array('status' => true, 'msg' => 'se genero el pdf');	
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}

		public function generar_pdf_entradas($fechas){
			$fechas_array = explode(',',$fechas);
			$pdf = new FPDF('L', 'mm', 'A4'); 
			$pdf->AddPage();
			$pdf->SetTitle('reporte de entradas');
			$arrData = $this->model->select_date_entradas( $fechas_array[0], $fechas_array[1]);
			if(empty($arrData)){
				$pdf->SetFont('Arial','B',14);
				$pdf->Cell(200,5,utf8_decode('no se realizo ninguna entrada hoy'),0,1,'C');
				$pdf->Ln();
			}else{
				$pdf->SetMargins(7,0,0);
				// encabezados de productos
				$pdf->SetFont('Arial','B',14);
				$pdf->Cell(15,5,utf8_decode('entradas de productos por fechas'),0,1,'L');
				$pdf->Ln();
							
				$pdf->SetFont('Arial','B',10);
				$pdf->SetFillColor(16, 39,154);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell(15,8,utf8_decode('N°'),0,0,'C',true);
				$pdf->Cell(55,8,utf8_decode('USUARIO'),0,0,'C',true);
				$pdf->Cell(60,8,utf8_decode('PROVEEDOR'),0,0,'C',true);
				$pdf->Cell(50,8,utf8_decode('TOTAL'),0,0,'C',true);
				$pdf->Cell(20,8,utf8_decode('ESTADO'),0,0,'C',true);
				$pdf->Cell(60,8,utf8_decode('HORA DE ENTRADA'),0,1,'C',true);
								
				$pdf->SetFont('Arial','',9);
				$pdf->SetLineWidth(0.2);
				$pdf->SetFillColor( 232, 232, 232 );
				$pdf->SetDrawColor( 232, 232, 232 );
				$pdf->SetTextColor(0,0,0);
				$i = 1;
				foreach($arrData as $row){
					if($row['status'] ==1){
						$estado = "completado";
					}else{
						$estado = "cancelado";
					}

					$pdf->Cell(15,8,$i,1,0,'C');
					$pdf->Cell(55,8,$row['username'],1,0,'C');
					$pdf->Cell(60,8,$row['proveedor'],1,0,'C');
					$pdf->Cell(50,8,$row['total'],1,0,'C');
					$pdf->Cell(20,8,$estado,1,0,'C');
					$pdf->Cell(60,8,$row['datecreated']." ".$row['timecreated'],1,0,'C');
					$pdf->Ln();
					$i++;
				}
			}
			$pdf->Output();
		}
		public function generar_pdf_salidas($fechas){
			$fechas_array = explode(',',$fechas);
			$pdf = new FPDF('L', 'mm', 'A4'); 
			$pdf->AddPage();
			$pdf->SetTitle('reporte de salida');
			$arrData = $this->model->select_date_salidas( $fechas_array[0], $fechas_array[1]);
			if(empty($arrData)){
				$pdf->SetFont('Arial','B',14);
				$pdf->Cell(200,5,utf8_decode('no se realizo ninguna salida hoy'),0,1,'C');
				$pdf->Ln();
			}else{
				$pdf->SetMargins(7,0,0);
				// encabezados de productos
				$pdf->SetFont('Arial','B',14);
				$pdf->Cell(15,5,utf8_decode('Salidas de productos por fechas'),0,1,'L');
				$pdf->Ln();
				
				$pdf->SetFont('Arial','B',9);
				$pdf->SetFillColor(16, 39,154);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell(15,8,utf8_decode('N°'),0,0,'C',true);
				$pdf->Cell(55,8,utf8_decode('VENDEDOR'),0,0,'C',true);
				$pdf->Cell(60,8,utf8_decode('CLIENTE'),0,0,'C',true);
				$pdf->Cell(50,8,utf8_decode('TOTAL'),0,0,'C',true);
				$pdf->Cell(20,8,utf8_decode('ESTADO'),0,0,'C',true);
				$pdf->Cell(60,8,utf8_decode('FECHA DE SALIDA'),0,1,'C',true);								
				$pdf->SetFont('Arial','',9);
				$pdf->SetLineWidth(0.2);
				$pdf->SetFillColor( 232, 232, 232 );
				$pdf->SetDrawColor( 232, 232, 232 );
				$pdf->SetTextColor(0,0,0);
				$i = 1;
				foreach($arrData as $row){
					if($row['status'] ==1){
						$estado = "completado";
					}else{
						$estado = "cancelado";
					}

					$pdf->Cell(15,8,$i,1,0,'C');
					$pdf->Cell(55,8,$row['username'],1,0,'C');
					$pdf->Cell(60,8,$row['cliente'],1,0,'C');
					$pdf->Cell(50,8,$row['total'],1,0,'C');
					$pdf->Cell(20,8,$estado,1,0,'C');
					$pdf->Cell(60,8,$row['datecreated']." ".$row['timecreated'],1,0,'C');
					$pdf->Ln();
					$i++;
				}
			}
			$pdf->Output();
		}

		public function kardex_productos(){
			$arrData = $this->model->selectKardex();
			for ($i=0; $i < count($arrData); $i++) {
				$button = '<button class="btn btn-success btn-sm" onClick="fntViewInfo('.$arrData[$i]['idmovimiento'].')" ><i class="fas fa-pallet fa-fw"></i></button>';
				$arrData[$i]['options'] = '<div class="text-center">'.$button.'</div>';
				$arrFecha = explode("-",$arrData[$i]['fecha']);
				if($arrFecha[0] == 1){
					$arrData[$i]['fechas'] = "Enero del ".$arrFecha[1] ;
				}if($arrFecha[0] == 2){
					$arrData[$i]['fechas'] = "Febrero del ".$arrFecha[1] ;
				}if($arrFecha[0] == 3){
					$arrData[$i]['fechas'] = "Marzo del ".$arrFecha[1] ;
				}if($arrFecha[0] == 4){
					$arrData[$i]['fechas'] = "Abril del ".$arrFecha[1] ;
				}if($arrFecha[0] == 5){
					$arrData[$i]['fechas'] = "Mayo del ".$arrFecha[1] ;
				}if($arrFecha[0] == 6){
					$arrData[$i]['fechas'] = "Junio del ".$arrFecha[1] ;
				}if($arrFecha[0] == 7){
					$arrData[$i]['fechas'] = "Julio del ".$arrFecha[1] ;
				}if($arrFecha[0] == 8){
					$arrData[$i]['fechas'] = "Agosto del ".$arrFecha[1] ;
				}if($arrFecha[0] == 9){
					$arrData[$i]['fechas'] = "Setiembre del ".$arrFecha[1] ;
				}if($arrFecha[0] == 10){
					$arrData[$i]['fechas'] = "Octubre del ".$arrFecha[1] ;
				}if($arrFecha[0] == 11){
					$arrData[$i]['fechas'] = "Noviembre del ".$arrFecha[1] ;
				}if($arrFecha[0] == 12){
					$arrData[$i]['fechas'] = "Diciembre del ".$arrFecha[1] ;
				}
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getProducto($idmovimiento){
			$arrData = $this->model->selectMovimiento($idmovimiento);
			for ($i=0; $i < count($arrData); $i++) {
				$arrFecha = explode("-",$arrData['fecha']);
				if($arrFecha[0] == 1){
					$arrData['fechas'] = "Enero del ".$arrFecha[1] ;
				}if($arrFecha[0] == 2){
					$arrData['fechas'] = "Febrero del ".$arrFecha[1] ;
				}if($arrFecha[0] == 3){
					$arrData['fechas'] = "Marzo del ".$arrFecha[1] ;
				}if($arrFecha[0] == 4){
					$arrData['fechas'] = "Abril del ".$arrFecha[1] ;
				}if($arrFecha[0] == 5){
					$arrData['fechas'] = "Mayo del ".$arrFecha[1] ;
				}if($arrFecha[0] == 6){
					$arrData['fechas'] = "Junio del ".$arrFecha[1] ;
				}if($arrFecha[0] == 7){
					$arrData['fechas'] = "Julio del ".$arrFecha[1] ;
				}if($arrFecha[0] == 8){
					$arrData['fechas'] = "Agosto del ".$arrFecha[1] ;
				}if($arrFecha[0] == 9){
					$arrData['fechas'] = "Setiembre del ".$arrFecha[1] ;
				}if($arrFecha[0] == 10){
					$arrData['fechas'] = "Octubre del ".$arrFecha[1] ;
				}if($arrFecha[0] == 11){
					$arrData['fechas'] = "Noviembre del ".$arrFecha[1] ;
				}if($arrFecha[0] == 12){
					$arrData['fechas'] = "Diciembre del ".$arrFecha[1] ;
				}
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		public function getTotalEntradas($idmovimiento){
			$arrData = $this->model->precio_entradas($idmovimiento);
			if(empty($arrData['total_entradas'])){
				$arrData['total_entradas'] = "0";
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		public function getTotalSalidas($idmovimiento){
			$arrData = $this->model->precio_salidas($idmovimiento);
			if(empty($arrData['total_salidas'])){
				$arrData['total_salidas']="0";
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		public function getKardexProducto($idmovimiento){
			$arrData = $this->model->selectKardexProducto($idmovimiento);
			$id = 1;
			for ($i = 0; $i < count($arrData); $i++) {
				$arrData[$i]['id'] = $id++;
				$arrData[$i]['precio_S'] = 's/. '.$arrData[$i]['precio'];
				$arrData[$i]['total_S'] = 's/. '.$arrData[$i]['total'];
				if ($arrData[$i]['tipo_movimiento'] == 1) {
					$arrData[$i]['tipomovimiento'] = 'Entrada';
				} else {
					$arrData[$i]['tipomovimiento'] = 'Salida';
				}
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
	}
?>