<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagBase.php';

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