<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuarBase.php';

	class FormContinuar extends FormContinuarBase
	{
		function __construct()
		{
			parent::__construct();

			$this->setValue
			(
				gettext
				(
					'Continuar'
				)
			);
		}
	}
?>