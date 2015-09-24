<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsObj.php';

	class GMapsSize extends GMapsObj
	{
		public function __construct($width , $height)
		{
			parent::__construct('size' , '=' , new GMapsProps(''));

			$this->props->add
			(
				new GMapsProp('x' , $width , $height)
			);
		}
	}
?>