<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMClassList.php';
	class DOMTag
	{
		public $domDoc;
		public $tag;
		public $classList;
		public $value;
		public $col;
		public $all;
		public $hijos;
		public $hijosLen;

		function __construct()
		{
			$this->domDoc=new DOMDocument;

			$this->all=$this->col=
			[
				'xs'=>false,
				'sm'=>false,
				'md'=>false,
				'lg'=>false
			];
			$this->hijos=[];
			$this->hijosLen=0;

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
		function appendChild(DOMTag $domTag)
		{
			$this->hijos[$this->hijosLen]=& $domTag;

			++$this->hijosLen;

			return $this;
		}
		public function setTagName($tagName)
		{
			$this->tag=$this->domDoc->createElement($tagName);
			$this->domDoc->appendChild($this->tag);

			$this->classList=new DOMClassList($this->tag);

			return $this;
		}
		public function setTagValue($val)
		{
			$this->tag->appendChild($this->domDoc->createTextNode($val));

			return $this;
		}
		public function render($childs , $childsLen ,  $doc)
		{
			for($i=0;$i<$childsLen;$i++)
			{
				$child=$childs[$i];

				$doc->appendChild
				(
					$this->domDoc->importNode
					(
						$child->renderChilds()->tag ,
						true
					)
				);
			}

			return $this;
		}
		function renderChilds()
		{
			return $this->render($this->hijos , $this->hijosLen , $this->tag);
		}
		public function getHTML()
		{
			$this->renderChilds();

			$innerHTML = ""; 
			$children  = $this->domDoc->childNodes;

			foreach ($children as $child) 
			{
				$innerHTML .= $this->domDoc->saveHTML($child);
			}

			return $innerHTML; 
		}
		public function setBootstrap($cols , $var)
		{
			$thisCols=& $this->$var;
			foreach($cols as $col=>$val)
			{
				$thisCols[$col]=$val;
			}
			$this->applyBootstrap($cols , $var);

			return $this;
		}
		public function setCol($cols)
		{
			$this->setBootstrap($cols , 'col');

			return $this;
		}
		public function setAll($cols)
		{
			$this->setBootstrap($cols , 'all');

			return $this;
		}
		public function applyBootstrap($cols , $var)
		{
			foreach($cols as $col=>$val)
			{
				if($val!==false)
				{
					$this->classList->add($var.'-'.$col.'-'.$val);
				}
			}
		}
		public function applyCol()
		{
			$this->applyBootstrap($this->col , 'col');
		}
		public function applyAll()
		{
			$this->applyBootstrap($this->all , 'all');
		}
	}
?>