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
				new FormCliSecSelect($this)
			)->appendChild
			(
				new FormCliAdd($this , 1)
			);

			$varConID=new VariablePost($this , 'conID' , $num);

			$this->appendChild
			(
				$varConID->setMulti(false)
			);
		}
	}
?>