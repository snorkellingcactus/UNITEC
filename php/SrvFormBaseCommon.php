<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormBase.php';
	

	class SrvFormBaseCommon extends FormBase
	{
		private $continuar;
		private $volver;
		//private 
		public function __construct()
		{
			parent::__construct('form');

			$this->continuar=false;
			$this->volver=false;
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

