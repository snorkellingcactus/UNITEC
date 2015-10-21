<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrdenEmptyOption.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrdenFillOption.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';

	class FormSelectOrdenOption extends DOMTagContainer
	{
		public $empty;
		public $fill;

		function __construct($parentForm , $name  , $value)
		{
			parent::__construct();

			$this->empty=new FormSelectOrdenEmptyOption($parentForm , $value);
			$this->fill=new FormSelectOrdenFillOption($parentForm , $name);

			//Revisar
			$this->empty->setTagValue
			(
				gettext('Arriba de').' '.$name
			);

			$this->appendChild
			(
				$this->empty
			);
			$this->appendChild
			(
				$this->fill
			);
		}
		function setSelected()
		{
			return $this->empty->setSelected();
		}
		function getValue()
		{
			return $this->empty->getValue();
		}
	}
?>