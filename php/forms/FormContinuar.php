<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputSubmit.php';

	class FormContinuar extends FormInputSubmit
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm);

			$this->setValue(gettext('Continuar'));
			$this->setName('Continuar');
		}
	}
?>