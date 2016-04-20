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

			$this->tagValue=false;

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
		public function setTag($tag)
		{
			$this->applyBootstrap();

			parent::setTag($tag);

			if($this->tagValue!==false)
			{
				$this->tag->appendChild
				(
					$this->getOwnerDocumentOf($this->parent->getTag())->createTextNode($this->tagValue)
				);
			}

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
/*
			echo '<pre>'.$this->tagName.'Class: ';
			print_r($this->getAttribute('class'));
			echo '</pre>';
*/
			return $this;
		}
		public function applySingleBootstrap($colType , $colName , $val)
		{
			//echo '<pre>$this->addToAttribute( "class" , '.$colType.'-'.$colName.'-'.$val.')';echo '</pre>';
			$this->addToAttribute('class' , $colType.'-'.$colName.'-'.$val);
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