
<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMClassList.php';

	class DOMTagBase extends DOMTagContainer
	{
		public $tagName;
		public $attrList;

		public $parent;

		function __construct()
		{
			parent::__construct();

			$this->attrList=[];

			$this->parent=false;
			$this->setTagName(false);

			$args=func_get_args();
			
			if(isset($args[0]))
			{
				$this->setTagName($args[0]);
			}			
		}
		public function setTag($tag)
		{
			//Condición para que funcione con Requirer.
			if($this->tagName!==false)
			{
				$this->parent=$tag;

				$this->tag=$this->newTag();

				return $this->applyAttrList();
			}
			else
			{
				return parent::setTag($tag);
			}
		}
		public function renderChilds(&$tag)
		{
			//echo '<pre>DOMTagBase '.get_class($this).'::renderChilds(&'.get_class($tag).')';

			parent::renderChilds($tag);

			if($this->tagName!==false)
			{
				//echo '<pre>Appending this to parent:';

				$this->parent->DOMAppendChild($this);

				//echo '</pre>';
			}

			//echo '</pre>';
		}
		public function setTagName($tagName)
		{
			$this->tagName=$tagName;

			return $this;
		}
		
		public function newTag()
		{
			return $this->getOwnerDocumentOf
			(
				$this->parent->getTag()
			)->createElement
			(
				$this->tagName
			);
		}
		public function appendXML($xml)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMFragment.php';
			
			//Revisar.
			return $this->appendChild
			(
				new DOMFragment($xml)
			);
		}
		public function applyAttrList()
		{
			$attrList=&$this->attrList;

			if( empty($attrList) )
			{
				return $this;
			}
			foreach($attrList as $attr=>$value)
			{
				if($value instanceof DOMClassList)
				{
					$value=$value->get();
				}

				$trimmed=trim($value);
/*
				if($trimmed!=='')
				{
*/
					$this->tag->setAttribute($attr , $value);
					unset( $attrList[$attr] );
/*				
				}
*/
			}

			return $this;
		}
		private function attrSetFilter(&$attrValue)
		{
			//Revisar. Esto se necesita en varios lados.
			if($attrValue===false)
			{
				$attrValue='false';
			}
			if($attrValue===0)
			{
				$attrValue='0';
			}
		}
		public function setAttributeList($name , $value)
		{
			$this->attrList[$name]=new DOMClassList($value);

			return $this;
		}
		public function setAttribute($attrName , $attrValue)
		{
			$this->attrSetFilter($attrValue);

			$attribute=&$this->attrList[$attrName];

			//Revisar . Buscar lo que tenga mejor rendimiento.
			if($attribute instanceof DOMClassList)
			{
				$attribute->set($attrValue);
			}
			else
			{
				$attribute=$attrValue;
			}

			return $this;
		}
		public function addToAttribute($attrName , $attrValue)
		{
			return $this->addReferenceToAttr($attrName , $attrValue);
		}
		public function addReferenceToAttr($attrName , &$attrValue)
		{
			$this->attrSetFilter($attrValue);

			if( !isset( $this->attrList[$attrName] ) )
			{
				$this->attrList[$attrName]=new DOMClassList();
			}

			$this->attrList[$attrName]->add($attrValue);

			return $this;
		}
		public function getAttribute($attrName)
		{
			$attribute=$this->attrList[$attrName];

			if($attribute instanceof DOMClassList)
			{
				return $attribute->get();
			}

			return $attribute;
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