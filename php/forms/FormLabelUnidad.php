<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';

	class FormLabelUnidad extends LabelBox
	{
		function __construct()
		{	
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectUnidad.php';
			
			parent::__construct
			(
				
				'Unidad',
				'unidad',
				gettext('Medir en'),
				new FormSelectUnidad()
			);
		}
	}
?>