<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmSec.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDelBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEdit.php';
	
	class FormCliCon extends FormCliAdmSec
	{
		function __construct($num , $id , $visible)
		{
			parent::__construct('accionesSec' , $id , $num , $visible);

			$this->buttons->appendChild
			(
				new FormCliDelBase(FormActions::FORM_ITEM_TYPE_B)
			)->appendChild
			(
				new FormCliEdit(FormActions::FORM_ITEM_TYPE_B)
			);

			$this->addToAttribute('class' , 'FormCliCon');
		}
	}
?>