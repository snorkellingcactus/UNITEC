<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrdenEmptyOption.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrdenFillOption.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';

	class FormSelectOrdenOption extends DOMTagContainer
	{
		public $empty;
		public $fill;
		function __construct($name  , $value)
		{
			parent::__construct();

			$this->empty=new FormSelectOrdenEmptyOption($value);
			$this->fill=new FormSelectOrdenFillOption($name);

			parent::appendTag
			(
				$this->empty
			);
			parent::appendTag
			(
				$this->fill
			);
		}
		function setSelected()
		{
			$this->empty->setSelected();
		}
		function getValue()
		{
			$this->fill->getValue();
		}
	}
?>