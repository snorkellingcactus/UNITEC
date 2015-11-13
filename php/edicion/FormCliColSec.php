<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliColAB.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecNew.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSec.php';

	class FormCliColSec extends FormCliColAB
	{
		function __construct($id , $orden , $visible)
		{
			parent::__construct();

			$this->setColA
			(
				new FormCliSecNew($id)
			)->setColB
			(
				new FormCliSec($id , $orden , $visible)
			);
		}
	}
?>