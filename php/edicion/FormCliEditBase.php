<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSubmit.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliEditBase extends FormCliSubmit
	{
		function __construct($form_item_type , $name)
		{
			parent::__construct
			(
				FormActions::FORM_ACTIONS_EDIT | $form_item_type,
				$name
			);

			$this->addToAttribute('class' , 'edita');
		}
	}
?>