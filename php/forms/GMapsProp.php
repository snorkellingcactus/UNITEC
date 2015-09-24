<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/Separatable.php';

	class GMapsProp extends Separatable
	{
		public $prop;
		public $value;

		function __construct($separator , $prop , $value)
		{
			parent::__construct($separator);

			$this->prop=$prop;
			$this->value=$value;
		}

		function encode()
		{
			return $this->prop.$this->separator.$this->value;
		}
	}
?>