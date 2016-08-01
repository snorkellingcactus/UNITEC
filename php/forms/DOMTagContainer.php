<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagObjectBase.php';
	
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
		public function setDelegateRender( $delegateRender )
		{
			$this->delegateRender=$delegateRender;
		}
		public function setDelegateAppend( $delegateAppend )
		{
			
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
		public function renderChild( &$child )
		{
			if($this->delegatedParent!==false && $this->delegateRender)
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
		public function renderChilds( &$tag )
		{
			$this->setTag($tag);

			$childs=$this->hijos;
			$childsLen=$this->hijosLen;

			for($i=0;$i<$childsLen;++$i)
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
		public function initRender()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMInitialTag.php';

			$this->renderChilds
			(
				new DOMInitialTag()
			);
		}
		public function getHTML()
		{
			$this->initRender();

			//Revisar.
			return $this->getOwnerDocumentOf( $this->tag )->saveHTML( $this->tag );
		}
		public function setTag( $tagObject )
		{
			if($this->delegateRender || $this->delegateAppend)
			{
				$this->delegatedParent=$tagObject;
			}

			$this->tag=$tagObject->getTag();
		}
	}
?>