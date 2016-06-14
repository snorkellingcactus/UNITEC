<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormBaseCommon.php';
	
	class SrvStepFormBase extends SrvFormBaseCommon
	{
		public $con;
		public $labels;
		private $title;

		function __construct()
		{
			parent::__construct();

			$this->appendChild
			(
				$this->title= new DOMTag('h1')
			);
		}
		public function makeLabels($index)
		{
			$this->labels=$this->newLabelsCollection($index);

			$this->autocomplete();

			return $this->labels;
		}
		//Que valla a una interface.
		public function newLabelsCollection(&$index)
		{

		}
		public function setTitle( $title )
		{
			$this->title->setTagValue( $title );
		}

		public function autocomplete()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$this->con=$con;
		}
		public function importReqs($domTag)
		{
			$this->addReqs($domTag->getReqs() , $domTag->getReqsLen());

			$domTag->delReqs();

			return $this;
		}
	}
?>

