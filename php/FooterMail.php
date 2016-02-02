<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMail.php';

	class FooterMail extends FooterContainer
	{
		function __construct()
		{
			parent::__construct();

			$this->appendChild
			(
				new FormCliMail()
			);
		}
	}
?>