<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliCompactBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEnviar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelCorreo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAsunto.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelMensaje.php';

	class FormCliMail extends FormCliCompactBase
	{
		function __construct()
		{
			parent::__construct('accionesMail');
			$this->classList->add('FormCliMail');

			$this->appendLabel
			(
				new FormLabelCorreo()
			)->appendLabel
			(
				new FormLabelAsunto()
			)->appendLabel
			(
				new FormLabelMensaje()
			)->appendChild
			(
				new FormCliEnviar()
			);
		}
		
		function appendChild($child)
		{
			$child->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];

			return parent::appendChild($child);
		}
	}
?>