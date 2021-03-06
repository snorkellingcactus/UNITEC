<?php
	class DOMClassList
	{
		private $attrLst;
		private $count;

		function __construct()
		{
			$this->attrLst=[];
			$this->count=0;
		}
		function add(&$name)
		{
			if(array_key_exists($name, $this->attrLst))
			{
				return;
			}

			$this->attrLst[$this->count]=&$name;

			++$this->count;

			return $this;
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

			return $this;
		}
		function get()
		{
			if(empty($this->attrLst))
			{
				return false;
			}

			return implode(' ' , $this->attrLst);
		}
		function set($value)
		{
			$this->attrLst=array($value);
		}
	}
?>