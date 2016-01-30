<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoSocial.php';

	class FooterInfoMail extends FooterInfoSocial
	{
		function __construct($mail)
		{
			parent::__construct
			(
				$mail,
				'/img/Mail.png',
				'mailto:'.$mail
			);
		}
	}
?>