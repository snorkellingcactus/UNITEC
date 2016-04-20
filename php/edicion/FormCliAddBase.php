<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSubmit.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliAddBase extends FormCliSubmit
	{
		function __construct($form_item_type , $name ,  $cMax)
		{
			parent::__construct
			(
				FormActions::FORM_ACTIONS_NEW | $form_item_type ,
				$name ,
				$cMax
			);

			$this->addToAttribute('class' , 'nuevo');
		}
	}
?>