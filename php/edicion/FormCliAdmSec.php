<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmRight.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

	class FormCliAdmSec extends FormCliAdmRight
	{
		function __construct($formDirName , $tipo , $orden , $id , $visible)
		{
			parent::__construct($formDirName);

			$varTipo=new VariablePost('Tipo' , $tipo);
			$varOrden=new VariablePost( 'Orden' , $orden);
			$varConID=new VariablePost('conID' , $id);

			$this->appendChild
			(
				$varTipo
			)->appendChild
			(
				$varOrden
			)->appendChild
			(
				$varConID
			);

			if(!$visible)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliHidden.php';

				$this->buttons->appendChild(new FormCliHidden());
			}
		}
	}
?>