<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsSepColon.php';

	class GMapsIcon extends GMapsSepColon
	{
		public function __construct($icon)
		{
			parent::__construct('icon' , $icon);
		}
	}
?>