<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliResponder.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

	class FormCliBtnRes extends FormCliBase
	{
		function __construct($raizID, $conID)
		{
			parent::__construct('accionesCom');

			$raizID=new VariablePost($this , 'RaizID' , $raizID);
			$conID=new VariablePost($this , 'conID' , $conID);

			$this->appendChild
			(
				$raizID->setMulti(0)
			)->appendChild
			(
				$conID->setMulti(0)
			)->appendChild
			(
				new FormCliResponder($this)
			)->classList->add
			(
				'FormCliComBtnRes'
			);
			
			//Revisar.
			if(isset($_POST['comConID']))
			{
				$this->setAttribute('id' , 'comRes');
			}

		}
	}
?>