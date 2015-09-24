<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsSepColon.php';

	class GMapsColor extends GMapsSepColon
	{
		public function __construct($color)
		{
			parent::__construct('color' , $color);
		}
	}
?>