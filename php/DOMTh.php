<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTCell.php';

	class DOMTh extends DOMTCell
	{
		function __construct()
		{
			parent::__construct('th');
		}
	}
?>