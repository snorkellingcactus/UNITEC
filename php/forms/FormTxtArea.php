<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';
	class FormTxtArea extends FormInputBase
	{
		function __construct()
		{
			parent::__construct('textarea');
		}	
	}
?>