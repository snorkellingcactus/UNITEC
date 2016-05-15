<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/BoolBox.php';

	class FormLabelAAMenu extends BoolBox
	{
		function __construct()
		{
			parent::__construct
			(
				'AgregarAlMenu',
				'agregarAlMenu',
				gettext('En el Menú')
			);
		}
	}
?>