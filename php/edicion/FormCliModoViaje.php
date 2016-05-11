<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';

	class FormCliModoViaje extends FormSelect
	{
		function __construct()
		{
			parent::__construct();

			$this->controller->addOption
			(
				$this->controller->buildOption
				(
					gettext('Auto'),
					'DRIVING'
				)->setSelected()
			)->addOption
			(
				$this->controller->buildOption
				(
					gettext('Bicicleta'),
					'BICYCLING'
				)
			)->addOption
			(
				$this->controller->buildOption
				(
					gettext('Caminando'),
					'WALKING'
				)
			);
		}
	}
?>