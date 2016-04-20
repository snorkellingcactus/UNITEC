
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
			parent::renderChilds($tag);

			if($this->tagName!==false)
			{
				$this->parent->DOMAppendChild($this);
			}
		}
		public function setTagName($tagName)
		{
			$this->tagName=$tagName;

			return $this;
		}
		
		public function newTag()
		{
			$tag=$this->getOwnerDocumentOf($this->parent->getTag())->createElement($this->tagName);

			return $tag;
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
			foreach($this->attrList as $attr=>$value)
			{
/*
				echo '<pre>Attribute Name '.$attr;
				echo '</pre>';
*/

				if($value instanceof DOMClassList)
				{
/*
					echo '<pre>Attribute Value:';
					print_r
					(
						$value->get()
					);
					echo '</pre>';
*/

					$value=$value->get();
				}

				$trimmed=trim($value);

				if($trimmed!=='')
				{
					$this->tag->setAttribute($attr , $value);
				}
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
			$this->attrSetFilter($attrValue);

			if(!isset($this->attrList[$attrName]))
			{
				$this->attrList[$attrName]=new DOMClassList($attrName);
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