<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecAddBase.php';

	class FormCliSecAddMenu extends FormCliSecAddBase
	{
		function __construct()
		{
			parent::__construct
			(
				'accionesMenu',
				'opc',
				gettext('Nueva Opción')
			);

			$this->classList->add('FormCliSecAddMenu');
		}
	}
?>