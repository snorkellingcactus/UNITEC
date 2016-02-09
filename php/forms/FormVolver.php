<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class FormVolver extends FormInput
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				$parentForm,
				'submit'
			);

			$this->setValue(gettext('Volver'))->setName('Volver')->classList->add('volver');
		}
	}
?>