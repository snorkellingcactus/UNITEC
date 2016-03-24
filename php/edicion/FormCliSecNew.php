<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdd.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdd.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

	class FormCliSecNew extends FormCliAdmBase
	{
		function __construct($num)
		{
			parent::__construct('accionesSec');

			$this->idSuffix=false;

			$this->setAttribute('id' , 'accionesCon'.$num)->classList->add('nCon');

			$this->buttons->appendChild
			(
				new FormCliSecSelect()
			)->appendChild
			(
				new FormCliAdd(1)
			);

			$varConID=new VariablePost('conID' , $num);

			$this->appendChild
			(
				$varConID
			);

			$this->classList->add('FormCliSecNew');
		}
	}
?>