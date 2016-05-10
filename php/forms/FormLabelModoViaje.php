<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';

	class FormLabelModoViaje extends LabelBox
	{
		function __construct()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliModoViaje.php';
			parent::__construct
			(
				
				'ModoViaje',
				'modo_viaje',
				gettext('Movilidad'),
				new FormCliModoViaje()
			);
		}
	}
?>