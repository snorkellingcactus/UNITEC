<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectLabel.php';

	class FormLabelUnidad extends FormSelectLabel
	{
		function __construct()
		{	
			parent::__construct
			(
				
				'Unidad',
				'unidad',
				gettext('Medir en')
			);

			$this->input->addOption
			(
				$this->input->buildOption
				(
					gettext('Metros'),
					'METRIC'
				)->setSelected()
			)->addOption
			(
				$this->input->buildOption
				(
					gettext('Imperial'),
					'IMPERIAL'
				)
			);
		}
	}
?>