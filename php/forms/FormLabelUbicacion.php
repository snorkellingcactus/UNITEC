<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLatitud.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLongitud.php';

	class FormFieldSet extends DOMTag
	{
		function __construct($name)
		{
			parent::__construct('fieldset');

			$this->appendChild
			(
				new DOMTag('legend' , $name)
			);
		}
	}

	class FormLabelUbicacion extends FormFieldSet
	{
		function __construct()
		{
			parent::__construct('Ubicacion');

			$this->latitud=new FormLabelLatitud();
			$this->longitud=new FormLabelLongitud();

			$this->appendChild
			(
				$this->latitud
			)->appendChild
			(
				$this->longitud
			);
		}
	}
?>