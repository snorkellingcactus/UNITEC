<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTMLUnitecBase.php';

	class HTMLUViewers extends DOMHTMLUnitecBase
	{
		function __construct()
		{
			parent::__construct();

			$this->addToUnset('RaizID');
		}
	}

?>

