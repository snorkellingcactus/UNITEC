<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';

	class FormCliSecSelect extends FormSelect
	{	
		function __construct()
		{
			parent::__construct();

			$this->setName('Tipo');

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$this->controller->addOption
			(
				$this->controller->newOption
				(
					gettext('Texto') ,
					strval
					(
						FormActions::FORM_ITEM_TYPE_B
					)
				)
			)->addOption
			(
				$this->controller->newOption
				(
					gettext('Módulo') ,
					strval
					(
						FormActions::FORM_ITEM_TYPE_C
					)
				)
			);
		}
	}
?>