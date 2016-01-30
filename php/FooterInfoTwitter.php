<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoFacebook.php';

	class FooterInfoTwitter extends FooterInfoSocial
	{
		function __construct($link)
		{
			parent::__construct('Twitter' , '/img/Twitter.png' , $link);
		}
	}
?>