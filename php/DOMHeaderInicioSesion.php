<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHeader.php';

	class DOMHeaderInicioSesion extends DOMHeader
	{
		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

			$link=new DOMLink();

			$this->appendChild
			(
				$link->setName(gettext('Ir al Inicio'))->setUrl('/')
			);
		}
	}
?>