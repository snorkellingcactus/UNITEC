<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class MSGBox extends DOMTag
	{
		function __construct($msg)
		{
			parent::__construct('h1' , $msg);

			$this->addToAttribute('class' , 'MSGBox');
		}
	}
?>