<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHeader.php';

	class DOMHeaderUnitec extends DOMHeader
	{
		function __construct()
		{
			parent::__construct();
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/MiniMapa.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

			/*$iniciarSesion=new DOMLink();*/

			$this->appendChild
			(
				new MiniMapa()
			)/*->appendChild
			(
				$iniciarSesion->setName( gettext('Iniciar Sesión') )->setUrl( '/inicio_sesion.php' )
			)*/->setAttribute('id' , 'header');

			$this->col=['xs' =>12 , 'sm' =>12 , 'md' =>12 , 'lg' =>12];
		}
	}
?>