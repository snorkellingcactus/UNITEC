<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHeader.php';

	class DOMHeaderUnitec extends DOMHeader
	{
		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLangUnitec.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/MiniMapa.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

			$iniciarSesion=new DOMLink();

			$this->appendChild
			(
				new DOMLangUnitec()
			)->appendChild
			(
				new MiniMapa()
			)->appendChild
			(
				$iniciarSesion->setName(gettext('Iniciar Sesión'))->setUrl('/inicio_sesion.php')
			)->setAttribute('id' , 'header');

			$this->addToAttribute('class' , 'hidden-xs');
		}
	}
?>