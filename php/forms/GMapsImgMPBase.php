<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsObj.php';

	class GMapsImgMPBase extends GMapsObj
	{
		//$coordX , $coordY , $color
		//$strCoord , $color
		public function __construct($name)
		{
			parent::__construct($name , '=' , new GMapsProps('|'));
		}
	}
?>