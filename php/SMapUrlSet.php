<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagBase.php';

	class SMapUrlSet extends DOMTagBase
	{
		function __construct()
		{
			parent::__construct('urlset');

			$this->setAttribute
			(
				'xmlns',
				'http://www.sitemaps.org/schemas/sitemap/0.9'
			);

			$this->setAttribute
			(
				'xmlns:xhtml',
				'http://www.w3.org/1999/xhtml'
			);
		}
	}
?>