<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';

	class FormCliSecSelect extends FormSelect
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm);

			$this->setName('Tipo')->addOption
			(
				$this->newOption(gettext('Texto') , 'con')
			)->addOption
			(
				$this->newOption(gettext('Módulo') , 'inc')
			)->setMulti(0);
		}
	}
?>