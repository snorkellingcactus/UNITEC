<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliIncMulti.php';

	class FormCliNov extends FormCliIncMulti
	{
		function __construct()
		{
			parent::__construct('accionesNov');
		}
	}
?>