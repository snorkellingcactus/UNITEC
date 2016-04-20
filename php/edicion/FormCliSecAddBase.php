<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmRight.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdd.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliSecAddBase extends FormCliAdmRight
	{
		function __construct($formDirName , $title)
		{
			parent::__construct($formDirName);

			$btnNew=new FormCliAdd(FormActions::FORM_ITEM_TYPE_A , 1);

			$this->appendChild
			(
				$btnNew->setValue('+')->setAttribute
				(
					'title',
					$title
				)
			);
		}
	}
?>