<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';

	class FormInputEnviar extends FormCliAddBase
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , gettext('Enviar') , 1);
		}
	}
?>