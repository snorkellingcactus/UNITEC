<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';
	//FormOption::__construct([$nombre[,$valor]])
	class FormSelectOption extends FormInputBase
	{
		function __construct()
		{
			parent::__construct('option');

			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->setTagValue($args[0]);
			}
			if(isset($args[1]))
			{
				$this->setValue($args[1]);
			}
		}
		function setSelected()
		{
			$this->tag->setAttribute('selected' , 'selected');

			return $this;
		}
	}
?>