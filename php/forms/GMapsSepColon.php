<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsProp.php';

	class GMapsSepColon extends GMapsProp
	{
		function __construct($prop , $value)
		{
			parent::__construct(':' , $prop , $value);
		}
		
	}
?>