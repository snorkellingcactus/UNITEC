<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsObj.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsSize.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsProp.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsProps.php';

	class GMapsImg extends GMapsObj
	{
		public $width;
		public $height;
		public $key;
		public $type;

		public function __construct($width , $height ,$key , $type)
		{
			parent::__construct
			(
				'https://maps.googleapis.com/maps/api/staticmap',
				'?',
				new GMapsProps('&')
			);

			$this->width=$width;
			$this->height=$height;

			$this->key=$key;
			$this->type=$type;

			$this->props->add
			(
				new GMapsSize($this->width , $this->height)
			)->add
			(
				new GMapsProp('=' , 'maptype'  , $this->type)
			);
		}

		public function encode()
		{

			$this->add
			(
				new GMapsProp('=' , 'key' , $this->key)
			);
			return parent::encode();
		}
	}
?>