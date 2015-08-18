<?php
	class DOMClassList
	{
		public $padre;
		public $attrLst;
		private $count;

		function __construct(DOMElement $padre)
		{
			$this->padre=$padre;
			$this->attrLst=[];
			$this->count=0;
		}
		function add($name)
		{
			if(array_key_exists($name, $this->attrLst))
			{
				return;
			}

			$this->attrLst[$this->count]=$name;

			++$this->count;

			return $this->applyAttrLst();
		}
		function del($name)
		{
			$attrLst=[];
			$count=0;
			foreach($this->attrLst as $key=>$value)
			{
				if($value!==$name)
				{
					$attrLst[$count]=$value;
					++$count;
				}
			}
			$this->attrLst=$attrLst;

			if(empty($attrLst) && $this->padre->hasAttribute('class'))
			{
				$this->padre->removeAttribute('class');
				return $this;
			}
			else
			{
				return $this->applyAttrLst();
			}
		}
		function applyAttrLst()
		{
			$this->padre->setAttribute
			(
				'class',
				implode(' ' , $this->attrLst)
			);

			return $this;
		}
	}
?>