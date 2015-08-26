<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';
	//FormOption::__construct([$nombre[,$valor]])
	class FormSelectOption extends FormInputBase
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'option');

			$args=func_get_args();

			if(isset($args[1]))
			{
				$this->setTagValue($args[1]);
			}
			if(isset($args[2]))
			{
				$this->setValue($args[2]);
			}
		}
		function setSelected()
		{
			$this->setAttribute('selected' , 'selected');

			return $this;
		}
	}
?>