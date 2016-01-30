<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliCompactBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliOk.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/PassBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelNombre.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

	class FormLabelContrasena extends PassBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Contrasena' , 'contrasena' , gettext('Contraseña'));
		}
	}


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

	$div=new DOMTag('div');
	$div->classList->add('LoginBox');
	$div->col=['xs'=>10 , 'sm'=>9 , 'md'=>7 , 'lg'=>7];

	$form=new FormCliLogin();
	echo $div->appendChild
	(
		$form
	)->getHTML();
?>