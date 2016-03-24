<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDel.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormCheckBox.php';

	class FormCliSelBase extends FormCliAdmBase
	{
		function __construct($formDirName)
		{
			parent::__construct($formDirName);
			
			$this->formId=$formDirName;
			
			$this->setAttribute('id' , $formDirName);

			$this->buttons->appendChild
			(
				new DOMTag
				(
					'span',
					gettext('Selección:')
				)
			)->appendChild
			(
				new FormCliDel()
			);
		}
		function buildActionCheckBox($num)
		{
			$checkBox=new FormCheckBox('conID' , $num);
			$checkBox->setAttribute('form' , $this->formId)->classList->add('semitrans');

			return $checkBox;
		}
	}
?>