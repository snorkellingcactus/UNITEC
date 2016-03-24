<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';

	class FormCliOk extends FormCliAddBase
	{
		function __construct()
		{
			parent::__construct(gettext('0K') , 1);
		}
	}
?>