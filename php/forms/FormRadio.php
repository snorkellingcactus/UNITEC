<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

class FormRadio extends FormInput
{
	function __construct($parentForm, $name , $value)
	{
		parent::__construct($parentForm , 'radio');

		$this->multi=false;
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