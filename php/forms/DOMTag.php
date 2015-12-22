<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMClassList.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	
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

	class DOMTag extends DOMTagBase
	{
		public $tagValue;
		public $col;
		public $all;

		function __construct()
		{
			parent::__construct();

			$this->tagValue=NULL;
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
		function renderChilds(&$doc , &$tag)
		{
			//echo '<pre>DOMTag::renderChilds()';echo '</pre>';

			return parent::renderChilds($doc , $tag);
		}
		public function createTag()
		{
			parent::createTag();

			if($this->tagValue!==NULL)
			{
				$this->tag->appendChild
				(
					$this->domDoc->createTextNode($this->tagValue)
				);
			}
			$this->applyBootstrap()->applyClassList();
		}
		public function setTagValue($tagValue)
		{
			$this->tagValue=$tagValue;

			return $this;
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
	}
?>