<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

//Revisar . implements FormRadio

class FormRadio extends FormInput
{
	function __construct($name , $value)
	{
		parent::__construct( 'radio');

		$this->setName($name);
		
		$this->setValue($value);
	}
	function setSelected()
	{
		$this->setAttribute('checked' , 'checked');
	}
}

?>