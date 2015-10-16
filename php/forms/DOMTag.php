<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMClassList.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	
	class DOMTag extends DOMTagContainer
	{
		public $tagName;
		public $tagValue;
		public $classList;
		public $attrList;
		public $value;
		public $col;
		public $all;

		function __construct()
		{
			parent::__construct();

			$this->attrList=[];

			$this->classList=new DOMClassList($this->tag);

			$this->all=$this->col=
			[
				'xs'=>false,
				'sm'=>false,
				'md'=>false,
				'lg'=>false
			];

			$args=func_get_args();
			if(isset($args[0]))
			{
				$this->setTagName($args[0]);
			}
			if(isset($args[1]))
			{
				$this->setTagValue($args[1]);
			}
		}
		public function setTagName($tagName)
		{
			$this->tagName=$tagName;

			return $this;
		}
		public function setTagValue($tagValue)
		{
			$this->tagValue=$tagValue;

			return $this;
		}
		public function applyBootstrap()
		{
			$col=& $this->col;
			$all=& $this->all;

			foreach($col as $colName=>$val)
			{
				if($val!==false)
				{
					$this->applySingleBootstrap('col' , $colName , $val);
				}
				if($all[$colName]!==false)
				{
					$this->applySingleBootstrap('all' , $colName , $all[$colName]);
				}
			}

			return $this;
		}
		public function applySingleBootstrap($colType , $colName , $val)
		{
			$this->classList->add($colType.'-'.$colName.'-'.$val);
		}
		public function setBootstrap($cols , $var)
		{
			$thisCols=& $this->$var;
			foreach($cols as $col=>$val)
			{
				$thisCols[$col]=$val;
			}

			return $this;
		}
		public function setCol($cols)
		{
			return $this->setBootstrap($cols , 'col');
		}
		public function setAll($cols)
		{
			return $this->setBootstrap($cols , 'all');
		}
		public function renderChilds(&$doc , &$tag)
		{
			//echo '<pre>DOMTag::renderChilds()';
			//echo '</pre>';
			$null=null;

			return parent::renderChilds($doc , $null);
		}
		public function createTag()
		{
			//echo '<pre>DOMTag::createTag()</pre>';
			$this->tag=$this->domDoc->createElement($this->tagName);
			$this->tag->appendChild
			(
				$this->domDoc->createTextNode($this->tagValue)
			);
			$this->domDoc->appendChild($this->tag);

			$this->applyBootstrap()->applyClassList()->applyAttrList();
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
		public function applyClassList()
		{
			$clases=$this->classList->get();

			if($clases!==false)
			{
				$this->tag->setAttribute('class' , $clases);
			}

			return $this;
		}
		public function applyAttrList()
		{
			foreach($this->attrList as $attr=>$value)
			{
				$this->tag->setAttribute($attr , $value);
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