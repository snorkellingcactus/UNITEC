<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

class FormRadio extends FormInput
{
	function __construct($name , $value)
	{
		parent::__construct( 'radio');

		if($name)
		{
			$this->setName($name);
		}
		
		$this->setValue($value);
	}
	function setSelected()
	{
		$this->setAttribute('checked' , 'checked');
	}
	function setName($name)
	{
		parent::setName($name);
	}
}

?>