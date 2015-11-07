<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabBase.php';

	class DOMLabUl extends DOMLabBase
	{
		function __construct()
		{
			parent::__construct('ul');
		}
	}
?>