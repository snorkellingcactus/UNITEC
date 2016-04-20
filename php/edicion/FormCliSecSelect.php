<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliSecSelect extends FormSelect
	{
		function __construct()
		{
			parent::__construct();

			$this->setName('Tipo')->addOption
			(
				$this->newOption(gettext('Texto') , strval(FormActions::FORM_ITEM_TYPE_B))
			)->addOption
			(
				$this->newOption(gettext('Módulo') , strval(FormActions::FORM_ITEM_TYPE_C))
			);
		}
	}
?>