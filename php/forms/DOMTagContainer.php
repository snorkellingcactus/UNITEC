<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	
	class DOMTagObjectBase
	{
		public $tag;

		function __construct()
		{
			$this->tag=false;
		}

		public function &getTag()
		{
			return $this->tag;
		}
		public function DOMAppendChild($tag)
		{
			$this->tag->appendChild($tag->getTag());
		}
	}
	class DOMTagContainer extends DOMTagObjectBase
	{
		public $hijos;
		public $hijosLen;
		public $delegatedParent;

		public function __construct()
		{
			parent::__construct();

			$this->hijos=[];
			$this->hijosLen=0;
			$this->delegatedParent=false;
			$this->delegate=true;
		}
		public function appendChild($tagObject)
		{
			$this->hijos[$this->hijosLen]= $tagObject;

			++$this->hijosLen;

			return $this;
		}
		public function DOMAppendChild($child)
		{
			if($this->delegatedParent===false)
			{
				parent::DOMAppendChild($child);
			}
			else
			{
				$this->delegatedParent->DOMAppendChild($child);
			}
		}
		public function renderChild(&$child)
		{
			$child->renderChilds
			(
				$this
			);
		}
		public function renderChilds(&$tag)
		{
			$this->setTag($tag);

			$childs=$this->hijos;
			$childsLen=$this->hijosLen;

			for($i=0;$i<$childsLen;$i++)
			{
				$this->renderChild($childs[$i]);
			}

			return $this;
		}
		public function getOwnerDocumentOf($node)
		{
			if($node->ownerDocument!==NULL)
			{
				return $node->ownerDocument;
			}

			return $node;
		}
		public function getHTML()
		{
			$this->delegate=false;
			$this->renderChilds(new DOMInitialTag());

			//Revisar.
			return html_entity_decode
			(
				$this->getOwnerDocumentOf($this->tag)->saveHTML($this->tag)
			);
		}
		public function setTag($tagObject)
		{
			if($this->delegate)
			{
				$this->delegatedParent=$tagObject;
			}
			$this->tag=$tagObject->getTag();
		}
	}

	class DOMInitialTag extends DOMTagObjectBase
	{
		function __construct()
		{
			parent::__construct();

			$this->tag=new DOMDocument('1.0' , 'UTF-8');
		}
	}
?>