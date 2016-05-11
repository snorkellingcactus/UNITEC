
<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';

	class FormSelectBool extends FormSelect
	{
		public $labelA;
		public $labelB;

		function __construct( $labelA , $labelB)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBoolController.php';
			
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