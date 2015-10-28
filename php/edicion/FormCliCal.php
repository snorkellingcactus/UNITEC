<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliIncMulti.php';

	class FormCliCal extends FormCliIncMulti
	{
		function __construct()
		{
			parent::__construct('accionesCal');
		}
	}
?>