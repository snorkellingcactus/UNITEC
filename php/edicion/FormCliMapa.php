<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliCompactBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliBuscarRuta.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelModoViaje.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUnidad.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelOrigen.php';

	class FormCliMapa extends FormCliCompactBase
	{
		function __construct()
		{
			parent::__construct('accionesMapa');

			//$titulo=new DOMTag('h1' , gettext('Nos interesa tu opinión!'));

			$ejemplo=new DOMTag('p' , gettext('Ej : Av 1 y 60, La Plata'));
			$ejemplo->col=['xs'=>12 , 'sm'=>7 , 'md'=>7 , 'lg'=>7];
			$ejemplo->classList->add('gris');

			$this->appendLabel
			(
				new FormLabelModoViaje($this)
			)->appendLabel
			(
				new FormLabelUnidad($this)
			)->appendLabel
			(
				new FormLabelOrigen($this)
			)->appendChild
			(
				$ejemplo
			)->appendChild
			(
				new FormCliBuscarRuta($this)
			)->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
		}
		function appendChild($child)
		{
			//$child->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];

			return parent::appendChild($child);
		}
	}
?>