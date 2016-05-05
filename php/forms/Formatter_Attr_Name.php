<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/Formatter_Attr_ID.php';
	
	class Formatter_Attr_Name extends Formatter_Attr_ID
	{
		public function getFormattedSuffix()
		{
			return '['.parent::getFormattedSuffix().']';
		}
	}
?>