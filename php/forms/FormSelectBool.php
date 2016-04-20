<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/printBool.php';
	class FormSelectBool extends FormSelect
	{
		public $labelA;
		public $labelB;

		function __construct( $labelA , $labelB)
		{
			parent::__construct();

			$this->labelA=$labelA;
			$this->labelB=$labelB;

			$this->setValueToSelect(0);
		}
		function renderChilds(&$tag)
		{
			$labelA=$this->labelA;
			$labelB=$this->labelB;

			if(!$this->valueToSelect)
			{
				$labelA=$this->labelB;
				$labelB=$this->labelA;
			}


			$this->addOption( $this->buildOption( $labelA , printBool($this->valueToSelect) ) );

			$this->addOption( $this->buildOption( $labelB , printBool(!$this->valueToSelect) ));

			return parent::renderChilds($tag);
		}
		public function trySelect($value)
		{
			return parent::trySelect(printBool($value));
		}
	}
?>