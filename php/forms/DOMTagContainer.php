<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	class DOMTagContainer
	{
		public $hijos;
		public $hijosLen;

		function __construct()
		{
			$this->hijos=[];
			$this->hijosLen=0;
		}
		function appendChild($domTag)
		{
			$this->hijos[$this->hijosLen]= $domTag;

			++$this->hijosLen;

			return $this;
		}
		public function render($childs , $childsLen ,  $doc)
		{
			for($i=0;$i<$childsLen;$i++)
			{
				$child=$childs[$i];

				$this->tag->appendChild
				(
					$doc->importNode
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
			$args=func_get_args();

			if(!isset($args[0]))
			{
				$args[0]=$this->createDoc();
			}
			return $this->render($this->hijos , $this->hijosLen , $args[0]);
		}
		function createDoc()
		{
			$domDoc=new DOMDocument();
			
			$this->createTag($domDoc);

			return $domDoc;
		}
		public function getHTML()
		{
			$doc=$this->createDoc();

			$this->renderChilds($doc);

			$innerHTML = ""; 
			$children  = $doc->childNodes;

			echo '<pre>ChildNodes:';
			print_r
			(
				$children
			);
			echo '</pre>';

			foreach ($children as $child) 
			{
				$innerHTML .= $doc->saveHTML($child);
			}

			return $innerHTML; 
		}
		/*function appendTag(DOMTag $domTag)
		{
			if(is_subclass_of($domTag, 'DOMTagContainer'))
			{
				$iMax=$domTag->hermanosLen;
				for($i=0;$i<$iMax;$i++)
				{
					$this->appendTag($domTag->hermanos[$i]);
				}
			}
			else
			{
				$this->hermanos[$this->hermanosLen]=$domTag;

				++$this->hermanosLen;
			}
			return $this;
		}*/
		function createTag($domDoc)
		{
			$this->tag=$domDoc;
		}
	}
?>