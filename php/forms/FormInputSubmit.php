<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class FormInputSubmit extends FormInput
	{
		function __construct()
		{
			parent::__construct('submit');
		}
	}
?>