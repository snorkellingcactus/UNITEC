<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormBase.php';
	

	class SrvStepFormBase extends FormBase
	{
		public $con;
		public $labels;
		private $continuar;
		private $volver;
		//private 
		public function __construct()
		{
			parent::__construct('form');

			$this->addToAttribute('class' , 'Form')->addToAttribute('class' ,'tresem');

			$this->setMethod('POST')->setEnctype('multipart/form-data');

			$this->continuar=false;
			$this->volver=false;
		}
		public function makeLabels()
		{
			$this->labels=$this->newLabelsCollection();

			$this->autocomplete();

			return $this->labels;
		}
		public function newLabelsCollection()
		{

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
		public function setAction($action)
		{
			$this->continuar=true;

			return parent::setAction($action);
		}
		public function enableVolver()
		{
			$this->volver=true;
		}
		function renderChilds(&$tag)
		{
			if($this->continuar===true)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';
				$this->appendChild
				(
					new FormContinuar()
				);
			}
			if($this->volver===true)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';
				$this->appendChild
				(
					new FormVolver()
				);
			}

			return parent::renderChilds($tag);
		}
		/*
		public function getReqs()
		{
			$iMax=parent::getReqsLen();
			$requiere=parent::getReqs();

			return $requiere;
		}
		*/
	}
?>

