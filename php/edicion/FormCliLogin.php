<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliCompactBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliOk.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelContrasena.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelNombre.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

	class FormCliLogin extends FormCliCompactBase
	{
		function __construct()
		{
			parent::__construct('accionesLogin');

			$this->appendChild
			(
				new DOMTag('h1' , gettext('Iniciar Sesión'))
			)->appendChild
			(
				new ClearFix()
			)->appendLabel
			(
				new FormLabelNombre($this)
			)->appendChild
			(
				new ClearFix()
			)->appendLabel
			(
				new FormLabelContrasena($this)
			)->appendChild
			(
				new ClearFix()
			)->appendChild
			(
				new FormCliOk($this)
			);

			$this->classList->add('FormCliLogin');
		}
	}
?>