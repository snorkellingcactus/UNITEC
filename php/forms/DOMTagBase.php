<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMClassList.php';

	class DOMTagBase extends DOMTagContainer
	{
		public $tagName;
		public $classList;
		public $attrList;

		function __construct()
		{
			parent::__construct();

			$this->attrList=[];

			$this->classList=new DOMClassList($this->tag);

			$args=func_get_args();
			
			if(isset($args[0]))
			{
				$this->setTagName($args[0]);
			}			
		}
		public function setTagName($tagName)
		{
			$this->tagName=$tagName;

			return $this;
		}
		public function renderChilds(&$doc , &$tag)
		{
			//echo '<pre>DOMTagBase::renderChilds()';echo '</pre>';

			$null=null;

			return parent::renderChilds($doc , $null);
		}
		public function createTag()
		{
			//echo '<pre>DOMTag::createTag()</pre>';
			$this->tag=$this->domDoc->createElement($this->tagName);

			$this->domDoc->appendChild($this->tag);

			$this->applyAttrList();

			//echo '<pre>DOMTagContainer::createTag()';
			//print_r($this->tag->tagName);
			//echo '</pre>';
			//echo '<pre>DOMTag::createTag()';
			//print_r($this->tag);
			//echo '</pre>';
		}
		public function appendXML($xml)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMFragment.php';
			
			return $this->appendChild
			(
				new DOMFragment($xml)
			);
		}
		public function applyAttrList()
		{
			foreach($this->attrList as $attr=>$value)
			{
				$trimmed=trim($value);
				if(!empty($trimmed))
				{
					$this->tag->setAttribute($attr , $value);
				}
			}

			return $this;
		}
		public function setAttribute($attrName , $attrValue)
		{
			$this->attrList[$attrName]=$attrValue;

			return $this;
		}
		public function getAttribute($attrName)
		{
			return $this->attrList[$attrName];
		}
		public function hasAttribute($attrName)
		{
			if(isset($this->attrList[$attrName]))
			{
				return true;
			}
			return false;

		}
	}

?>