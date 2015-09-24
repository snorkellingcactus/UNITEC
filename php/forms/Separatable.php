<?php
	class Separatable
	{
		public $separator;

		public function __construct($separator)
		{
			$this->setSeparator($separator);
		}

		public function addSeparatorTo(&$buff)
		{
			$buff=$buff.$this->separator;

			return $buff;
		}
		public function setSeparator($separator)
		{
			$this->separator=$separator;
		}
	}
?>