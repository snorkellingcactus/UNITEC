<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';

	class FormLabelImagen extends TituloBox
	{
		function __construct($name , $id , $labelText)
		{
			//Revisar []
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/RadioLstNov.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

			$this->label->setTagValue($labelText);
			$this->label->setAttribute('id' , $id);

			$this->appendChild
			(
				new ClearFix()
			)->appendChild
			(
				$this->input=new RadioLstNov
				(
					$name
					$this->label->getAttribute('id')
				)
			)->addToAttribute('class' , 'FormLabelImagen');
		}
	}
?>