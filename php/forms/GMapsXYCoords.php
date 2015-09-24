<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsProp.php';

	class GMapsXYCoords extends GMapsProp
	{
		public function __construct($coordX , $coordY)
		{
			parent::__construct(',' , $coordX , $coordY);
		}
	}
?>