<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadioLst.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadio.php';

	class RadioLstNov extends FormImgRadioLst
	{
		public $labelID;
		function __construct($parentForm , $name , $labelID)
		{
			parent::__construct($parentForm , $name);
			$this->labelID=$labelID;
		}

		function buildNew($value)
		{
			return new FormImgRadio($this->parentForm , $this->name , $value);
		}
		function add($checkbox)
		{
			$checkbox->input->setAttribute('aria-labelledby' ,$this->labelID);

			parent::add($checkbox);
		}
		function setID($id)
		{
			$this->id=$id;

			return $this;
		}
		function appendLabel()
		{
			return $this;
		}
		function setCol($col)
		{
			return $this;
		}
	}
?>