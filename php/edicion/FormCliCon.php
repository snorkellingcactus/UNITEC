<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmSec.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDel.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEdit.php';
	
	class FormCliCon extends FormCliAdmSec
	{
		function __construct($num , $id , $visible)
		{
			parent::__construct('accionesSec' , 'con' , $id , $num , $visible);

			$this->buttons->appendChild
			(
				new FormCliDel($this)
			)->appendChild
			(
				new FormCliEdit($this)
			);
		}
	}
?>