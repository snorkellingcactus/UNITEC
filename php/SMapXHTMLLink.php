<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagBase.php';

	class SMapXHTMLLink extends DOMTagBase
	{
		function __construct($lang , $resource)
		{
			parent::__construct('xhtml:link');

			$this->setAttribute
			(
				'rel' ,
				'alternate'
			)->setAttribute
			(
				'hreflang',
				$lang
			)->setAttribute
			(
				'href',
				$resource
			);
/*
			$this->setAttribute
			(
				'xmlns:xhtml',
				'http://www.w3.org/1999/xhtml'
			);
*/
		}
	}
?>