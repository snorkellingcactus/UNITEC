<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliIncBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliNumSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormCheckBox.php';

	class FormCliIncMulti extends FormCliIncBase
	{
		function __construct($formDirName)
		{
			parent::__construct
			(
				$formDirName ,
				new FormCliNumSelect($this)
			);

			$this->formId=$formDirName;
			
			$this->setAttribute('id' , $formDirName);
		}
		function buildActionCheckBox($num)
		{
			$checkBox=new FormCheckBox($this , 'conID' , $num);
			$checkBox->setAttribute('form' , $this->formId)->classList->add('semitrans');

			return $checkBox;
		}
	}
?>