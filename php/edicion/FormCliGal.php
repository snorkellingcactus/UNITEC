<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliIncMulti.php';

	class FormCliGal extends FormCliIncMulti
	{
		function __construct()
		{
			parent::__construct('accionesGal');
		}
	}
?>