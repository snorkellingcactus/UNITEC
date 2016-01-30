<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';

	class FormCliOk extends FormCliAddBase
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , gettext('0K') , 1);
		}
	}
?>