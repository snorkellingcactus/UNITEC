<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBase.php';


	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/printBool.php';
	class FormSelectBoolController extends FormSelectController
	{
		public function trySelect($value)
		{
			return parent::trySelect
			(
				printBool
				(
					$value
				)
			);
		}
		public function buildOption()
		{
			$args=func_get_args();

			return parent::buildOption
			(
				$args[0] ,
				printBool
				(
					$args[1]
				)
			);
		}
	}

	class FormSelectBool extends FormSelect
	{
		public $labelA;
		public $labelB;

		function __construct( $labelA , $labelB)
		{
			parent::__construct();

			$this->labelA=$labelA;
			$this->labelB=$labelB;

			$this->controller->setValueToSelect(0);
		}
		function newController()
		{
			return new FormSelectBoolController();
		}
		function renderChilds(&$tag)
		{
			$controller=$this->controller;

			$valueToSelect=$controller->getValueToSelect();

			if(!$valueToSelect)
			{
				$labelA=$this->labelB;
				$labelB=$this->labelA;
			}
			else
			{
				$labelA=$this->labelA;
				$labelB=$this->labelB;
			}

			$controller->addOption
			(
				$controller->buildOption
				(
					$labelA ,
					$valueToSelect		
				)
			)->addOption
			(
				$controller->buildOption
				(
					$labelB ,
					!$valueToSelect
				)
			);

			return parent::renderChilds($tag);
		}
	}
?>