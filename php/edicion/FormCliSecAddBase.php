<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmRight.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class FormCliSecAddBase extends FormCliAdmRight
	{
		function __construct($formDirName , $tipo , $title)
		{
			parent::__construct($formDirName);

			$varTipo=new VariablePost($this , 'Tipo' , $tipo);

			$btnNew=new FormInput($this , 'submit');

			$this->appendChild
			(
				$varTipo->setMulti(0)
			)->appendChild
			(
				$btnNew->setValue('+')->setAttribute
				(
					'title',
					$title
				)->setName('nuevo')->setMulti(0)
			);
		}
	}
?>