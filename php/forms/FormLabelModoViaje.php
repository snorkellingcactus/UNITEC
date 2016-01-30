<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectLabel.php';

	class FormLabelModoViaje extends FormSelectLabel
	{
		function __construct($parentForm)
		{	
			parent::__construct
			(
				$parentForm,
				'ModoViaje',
				'modo_viaje',
				gettext('Movilidad')
			);

			$this->input->addOption
			(
				$this->input->buildOption
				(
					gettext('Auto'),
					'DRIVING'
				)->setSelected()
			)->addOption
			(
				$this->input->buildOption
				(
					gettext('Bicicleta'),
					'BICYCLING'
				)
			)->addOption
			(
				$this->input->buildOption
				(
					gettext('Caminando'),
					'WALKING'
				)
			);
		}
	}
?>