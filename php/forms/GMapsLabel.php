<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsSepColon.php';

	class GMapsLabel extends GMapsSepColon
	{
		public function __construct($label)
		{
			parent::__construct('label' , $label);
		}
	}
?>