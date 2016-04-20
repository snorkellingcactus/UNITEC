<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	
	class FormCliSep extends DOMTag
	{
		function __construct()
		{
			parent::__construct('div');

			$this->addToAttribute('class' , 'sep');
		}
	}
?>