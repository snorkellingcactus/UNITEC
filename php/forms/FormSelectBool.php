<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/printBool.php';
	class FormSelectBool extends FormSelect
	{
		public $labelA;
		public $labelB;

		function __construct($parentForm , $labelA , $labelB)
		{
			parent::__construct($parentForm);

			$this->labelA=$labelA;
			$this->labelB=$labelB;

			$this->selectedValue=0;
		}
		function renderChilds(&$doc , &$tag)
		{
			$labelA=$this->labelA;
			$labelB=$this->labelB;

			if(!$this->selectedValue)
			{
				$labelA=$this->labelB;
				$labelB=$this->labelA;
			}

			$this->addOption(new FormSelectOption($this->parentForm , $labelA , intVal($this->selectedValue)));
			$this->addOption(new FormSelectOption($this->parentForm , $labelB , intVal(!$this->selectedValue)));
/*
			echo '<pre>SelectedValue (Bool):';
			var_dump($this->selectedValue);
			echo '</pre>';
*/
			return parent::renderChilds($doc , $tag);
		}
		function mustBeSelected($value)
		{
			if($this->selectedValue===printBool($value))
			{
				return true;
			}
			return false;
		}
	}
?>