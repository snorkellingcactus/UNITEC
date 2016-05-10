<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugarBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrden.php';
	
	class FormLabelLugar extends FormLabelLugarBase
	{
		function __construct()
		{
			parent::__construct
			(
				'Lugar',
				'lugar',
				gettext('Lugar'),
				new FormSelectOrden()
			);
		}
		function setInput($input)
		{
			$input->addToAttribute('class' , 'orden')->setSizeToMax()
			->controller->setDefaultToMax();

			parent::setInput($input);
		}
	}
?>