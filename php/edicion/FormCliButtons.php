<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class FormCliButtons extends DOMTag
	{
		function __construct()
		{
			parent::__construct('p');
			
			$this->classList->add('acciones');
		}
	}
?>