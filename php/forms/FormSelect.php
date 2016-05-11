<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';

	class FormSelect extends FormInputBase
	{
		public $controller;
		private $sizeToMax;

		function setSize($size)
		{
			return $this->setAttribute('size' , $size);
		}
		function setSizeToMax()
		{
			$this->sizeToMax=true;

			return $this;
		}

		function getSizeToMax()
		{
			return $this->sizeToMax;
		}

		function __construct()
		{
			parent::__construct( 'select' );

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectController.php';

			$this->controller=$this->newController();
			$this->controller->setView($this);

			$this->sizeToMax=false;
		}
		function newController()
		{
			return new FormSelectController();
		}
		function renderChilds(&$tag)
		{
			$this->controller->onRenderChilds();

			if($this->sizeToMax)
			{
				$this->setSize($this->controller->getOptionsLen());
			}

			return parent::renderChilds($tag);
		}
	}
?>