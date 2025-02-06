<?php 

	class Errors extends Controller{
		public function __construct()
		{
			parent::__construct();
		}

		public function notFound()
		{
			$data['page_title'] = "Error";
			$this->views->getView($this,"error",$data);
		}
	}

	$notFound = new Errors();
	$notFound->notFound();
 ?>