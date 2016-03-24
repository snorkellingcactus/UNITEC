<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';

	class FormCliResponder extends FormCliAddBase
	{
		function __construct()
		{
			parent::__construct(gettext('Responder') , 1);
		}
	}
?>