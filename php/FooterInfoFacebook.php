<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoSocial.php';

	class FooterInfoFacebook extends FooterInfoSocial
	{
		function __construct($link)
		{
			parent::__construct('Facebook' , '/img/Facebook.png' , $link);
		}
	}
?>