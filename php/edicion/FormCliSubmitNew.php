<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliSubmit extends FormInput
	{
		function __construct($form_action_type , $value)
		{
			parent::__construct('submit');

			$this->setName
			(
				FormActions::FORM_ACTION_PREFIX.$form_action_type
			)->setValue
			(
				$value
			)->setAttribute
			(
				'title',
				$value
			);
		}
	}
?>