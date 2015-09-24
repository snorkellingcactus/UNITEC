<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/RadioLstNov.php';

	class FormLabelImagen extends TituloBox
	{
		function __construct($parentForm , $name , $id , $labelText)
		{
			//Revisar []
			parent::__construct();
			$this->label->setTagValue($labelText);
			$this->label->setAttribute('id' , $id.$parentForm->idSuffix);

			$this->input=new RadioLstNov($parentForm , $name.'['.$parentForm->idSuffix.']' , $this->label->getAttribute('id'));
			$this->appendChild($this->input);
		}
	}
?>