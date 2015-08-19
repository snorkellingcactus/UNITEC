<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrden.php';

	class FormLugar extends LabelBox
	{
		function __construct()
		{
			parent::__construct
			(
				'Lugar',
				'lugar',
				'Lugar',
				new FormSelectOrden
				(
					[
						'LugarA',
						'LugarB',
						'LugarC'
					]
				)
			);
			$this->input
			->autoAddOptions()
			->setSizeToMax()
			->setDefaultToMax()
			->addReq('/forms/forms.css')
			->classList->add('orden');
		}
	}
?>