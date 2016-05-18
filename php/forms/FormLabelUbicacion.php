<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormFieldSet.php';

	class FormLabelUbicacion extends FormFieldSet
	{
		public $latitud;
		public $longitud;

		function __construct()
		{
			parent::__construct('Ubicacion');

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLatitud.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLongitud.php';

			$this->appendChild
			(
				$this->latitud=new FormLabelLatitud()
			)->appendChild
			(
				$this->longitud=new FormLabelLongitud()
			);
		}
	}
?>