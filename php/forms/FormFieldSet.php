<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	
	class FormFieldSet extends DOMTag
	{
		function __construct($name)
		{
			parent::__construct('fieldset');

			$this->appendChild
			(
				new DOMTag('legend' , $name)
			);
		}
	}
?>