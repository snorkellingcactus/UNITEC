<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugarBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrden.php';
	
	class FormLabelLugar extends FormLabelLugarBase
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				'Lugar',
				'lugar',
				gettext('Lugar'),
				new FormSelectOrden($parentForm)
			);
		}
		function setInput($input)
		{
			$input
			->setSizeToMax()
			->setDefaultToMax()
			->classList->add('orden');

			parent::setInput($input);
		}
	}
?>