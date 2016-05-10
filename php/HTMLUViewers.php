<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUNormal.php';

	class HTMLUViewers extends HTMLUNormal
	{
		function __construct()
		{
			parent::__construct();

			$this->addToUnset('RaizID');
		}
	}

?>

