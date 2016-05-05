<?php
	class Formatter_Attr_ID
	{
		private $suffix;
		private $preffix;
		private $formatted;

		function __construct(&$suffix)
		{
			$this->setPreffix(false);
			$this->setSuffix($suffix);
		}
		public function hasSetted()
		{
			return $this->preffix!==false;
		}
		public function &getFormatted()
		{
			return $this->formatted;
		}
		public function update()
		{
			if($this->hasSetted())
			{
				$this->formatted=$this->getPreffix().$this->getFormattedSuffix();
			}
		}
		public function setPreffix($preffix)
		{

			$this->preffix=$preffix;

			$this->update();

			return $this;
		}
		public function setSuffix(&$suffix)
		{
			$this->suffix=$suffix;

			$this->update();
		}
		public function getPreffix()
		{
			return $this->preffix;
		}
		public function getSuffix()
		{
			return $this->suffix;
		}
		public function getFormattedSuffix()
		{
			return $this->getSuffix();
		}
	}
?>