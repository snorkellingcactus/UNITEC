<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';

	class FormSelectUnidad extends FormSelect
	{
		function __construct()
		{	
			parent::__construct();

			$this->controller->addOption
			(
				$this->controller->buildOption
				(
					gettext('Metros'),
					'METRIC'
				)->setSelected()
			)->addOption
			(
				$this->controller->buildOption
				(
					gettext('Imperial'),
					'IMPERIAL'
				)
			);
		}
	}
?>