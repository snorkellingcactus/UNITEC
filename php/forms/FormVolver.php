<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class FormVolver extends FormInput
	{
		function __construct()
		{
			parent::__construct
			(
				
				'submit'
			);

			$this->setValue(gettext('Volver'))->setName('Volver')->classList->add('volver');
		}
	}
?>