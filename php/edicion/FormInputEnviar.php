<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';

	class FormInputEnviar extends FormCliAddBase
	{
		function __construct()
		{
			parent::__construct(gettext('Enviar') , 1);
		}
	}
?>