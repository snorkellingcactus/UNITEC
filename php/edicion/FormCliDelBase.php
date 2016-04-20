<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSubmit.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliDelBase extends FormCliSubmit
	{
		function __construct($form_item_type)
		{
			parent::__construct
			(
				 FormActions::FORM_ACTIONS_DELETE | $form_item_type ,
				 gettext('Eliminar')
			);

			$this->addToAttribute('class' , 'elimina');
		}
	}
?>