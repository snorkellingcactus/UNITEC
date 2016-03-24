<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelTwitter extends TextBox
	{
		function __construct()
		{
			parent::__construct( 'Twitter' , 'twitter' , gettext('Twitter'));
		}
	}
?>