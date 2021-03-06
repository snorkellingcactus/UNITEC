<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDelBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormCheckBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliSelBase extends FormCliAdmBase
	{
		private $checkBoxCount;

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
				new FormCliDelBase(FormActions::FORM_ITEM_TYPE_A)
			);

			$this->checkBoxCount=0;
		}
		function buildActionCheckBox($num)
		{
			$checkBox=new FormCheckBox('conID' , $num);
			$checkBox->setIndex( $this->checkBoxCount )
			->setAttribute( 'form' , $this->formId )
			->addToAttribute( 'class' , 'semitrans' );

			++$this->checkBoxCount;

			return $checkBox;
		}
	}
?>