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
//			echo '<pre>'.$this->tag->nodeName.'::appendChild('.$tag->getTag()->nodeName.')'; echo '</pre>';
			$this->tag->appendChild($tag->getTag());
		}
	}
	class DOMTagContainer extends DOMTagObjectBase
	{
		public $hijos;
		public $hijosLen;
		public $delegatedParent;
		public $delegateRender;
		public $delegateAppend;

		public function __construct()
		{
			parent::__construct();

			$this->hijos=[];
			$this->hijosLen=0;
			$this->delegatedParent=false;

			$this->delegateRender=false;
			$this->delegateAppend=true;
		}
		public function appendChild($tagObject)
		{
			$this->hijos[$this->hijosLen]= $tagObject;

			++$this->hijosLen;

			return $this;
		}
		public function DOMAppendChild($child)
		{
			//echo '<pre>'.get_class($this).'::DOMAppendChild('.get_class($child).')';
			

			if(!$this->delegatedParent===false && $this->delegateAppend)
			{
/*
				echo '<pre>Delegate to '.
				get_class($this->delegatedParent).
				'::DOMAppendChild('.get_class($child).')';
*/				

				$this->delegatedParent->DOMAppendChild($child);

//				echo '</pre>';
			}
			else
			{
				parent::DOMAppendChild($child);
			}

			//echo '</pre>';
		}
		public function renderChild(&$child)
		{
			if(!$this->delegatedParent===false && $this->delegateRender)
			{
				$child->renderChilds
				(
					$this->delegatedParent
				);
			}
			else
			{
				$child->renderChilds
				(
					$this
				);
			}
		}
		public function renderChilds(&$tag)
		{
			//echo '<pre>DOMTagContainer '.get_class($this).'::renderChilds(&'.get_class($tag).')';
			$this->setTag($tag);

			$childs=$this->hijos;
			$childsLen=$this->hijosLen;

			for($i=0;$i<$childsLen;$i++)
			{
				//echo '<pre>Initialize rendering of '.get_class($this).' child '.$i;echo '</pre>';
				$this->renderChild($childs[$i]);

				//echo '<pre>Finalize   rendering of '.get_class($this).' child '.$i;echo '</pre>';
			}

			//echo '</pre>';

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
			if($this->delegateRender || $this->delegateAppend)
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