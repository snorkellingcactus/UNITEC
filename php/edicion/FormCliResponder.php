<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';

	class FormCliResponder extends FormCliAddBase
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , gettext('Responder') , 1);
		}
	}
?>