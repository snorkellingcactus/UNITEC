<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliLogin.php';

	class LoginBox extends DOMTag
	{
		function __construct()
		{
			parent::__construct('div');

			$this->addToAttribute('class' , 'LoginBox');
			$this->col=['xs'=>10 , 'sm'=>9 , 'md'=>7 , 'lg'=>7];

			$this->appendChild
			(
				new FormCliLogin()
			);
		}
	}
?>