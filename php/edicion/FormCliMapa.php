<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliCompactBase.php';


	class FormCliMapa extends FormCliCompactBase
	{
		function __construct()
		{
			parent::__construct('accionesMapa');

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMapa.php';

			$this->appendChild
			(
				new LabelsMapa()
			);
		}
	}
?>