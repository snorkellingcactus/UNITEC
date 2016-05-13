<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputSubmit.php';

	class FormContinuarBase extends FormInputSubmit
	{
		function __construct()
		{
			parent::__construct();

			$this->setName( 'Continuar' );
		}
	}
?>