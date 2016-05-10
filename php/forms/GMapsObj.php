<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/Separatable.php';

	class GMapsObj extends Separatable
	{
		public $name;
		public $props;

		function __construct($name , $separator , $props)
		{
			parent::__construct($separator);

			$this->name=$name;
			$this->props=$props;
		}
		function add($toAdd)
		{
			return $this->props->add($toAdd);
		}
		function encode()
		{
			return $this->addSeparatorTo($this->name).$this->props->encode();
		}
	}
?>