<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrden.php';
	
	class FormLabelLugar extends FormLabelLugarBase
	{
		function __construct()
		{
			parent::__construct
			(
				'Lugar',
				'lugar',
				'Lugar',
				new FormSelectOrden()
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