<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTMLUnitecBase.php';

	class HTMLUNormal extends DOMHTMLUnitecBase
	{
		function __construct()
		{
			parent::__construct();

			$this
			->addToUnset('form')
			->addToUnset('conID')
			->addToUnset('accion')
			->addToUnset('referer');
		}
	}

?>

