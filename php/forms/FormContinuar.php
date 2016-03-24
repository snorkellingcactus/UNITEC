<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputSubmit.php';

	class FormContinuar extends FormInputSubmit
	{
		function __construct()
		{
			parent::__construct();

			$this->setValue(gettext('Continuar'));
			$this->setName('Continuar');
		}
	}
?>