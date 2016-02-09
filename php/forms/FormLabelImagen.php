<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';

	class FormLabelImagen extends TituloBox
	{
		function __construct($parentForm , $name , $id , $labelText)
		{
			//Revisar []
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/RadioLstNov.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

			$this->label->setTagValue($labelText);
			$this->label->setAttribute('id' , $id.$parentForm->idSuffix);

			$this->appendChild
			(
				new ClearFix()
			)->appendChild
			(
				$this->input=new RadioLstNov
				(
					$parentForm ,
					$name.'['.$parentForm->idSuffix.']',
					$this->label->getAttribute('id')
				)
			)->classList->add('FormLabelImagen');
		}
	}
?>