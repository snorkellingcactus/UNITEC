<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	class FormLabel extends DOMTag
	{
		function __construct()
		{
			parent::__construct();

			$this->setTagName('label');

			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->setTagValue($args[0]);
			}
		}
		function setFor($input)
		{
			$this->tag->setAttribute('for' , $input->getID());
		}
	}
?>