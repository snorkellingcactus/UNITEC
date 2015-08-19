<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/BoolBox.php';

	class AgregarAlMenu extends BoolBox
	{
		function __construct()
		{
			parent::__construct
			(
				'AgregarAlMenu',
				'agregarAlMenu',
				'Agregar al Menú'
			);
		}
	}
?>