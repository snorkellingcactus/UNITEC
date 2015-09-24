<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsSepColon.php';

	class GMapsWeight extends GMapsSepColon
	{
		public function __construct($weight)
		{
			parent::__construct('weight' , $weight);
		}
	}
?>