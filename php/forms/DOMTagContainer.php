<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	
	class DOMTagContainer
	{
		public $hijos;
		public $hijosLen;
		public $domDoc;
		public $tag;

		public function __construct()
		{
			$this->hijos=[];
			$this->hijosLen=0;
		}
		public function appendChild($domTag)
		{
			$this->hijos[$this->hijosLen]= $domTag;

			++$this->hijosLen;

			return $this;
		}
		/*
		public function render($childs , $childsLen)
		{
			echo '<pre>DOMTagContainer::render()';
			echo '</pre>';
			for($i=0;$i<$childsLen;$i++)
			{
				$child=$childs[$i];

				$tName='Doc';
				if(isset($this->tag->tagName))
				{
					$tName=$this->tag->tagName;
				}
				echo '<pre>'.$tName.'->appendChild->';
				echo '</pre>';
				$this->tag->appendChild
				(
					$child->renderChilds($this->domDoc)->tag ,
					true
				);
			}

			return $this;
		}
		*/
		public function importChild($child)
		{
			/*
			echo '<pre>DOMTag::importChild()'."\n";
			echo '$this->tag : ';
			echo $this->getName($this->tag)."\n";
			echo '$this->domDoc : ';
			echo $this->getName($this->domDoc)."\n";
			*/

			$res=$child->renderChilds
			(
				$this->domDoc ,
				$this->tag
			);

			if($res instanceof DOMTag)
			{
				//echo '<pre>'.$this->getName($this->tag).'->appendChild('.$this->getName($res).')</pre>';
				$this->tag->appendChild
				(
					$res->tag
				);
			}
/*
		function getName($tag)
		{
			$tName='Doc';
			if(isset($tag->tagName))
			{
				$tName=$tag->tagName;
			}

			return $tName;
		}
*/
/*
			echo 'DOMTag::importChild()'."\n";
			echo '$child->tag : ';
			echo $this->getName($res->tag)."\n";
			echo '$child->domDoc : ';
			echo $this->getName($res)."\n";
			echo '$child->className : ';
			echo ($res instanceof DOMTag)."\n";
			echo '</pre>';
*/
			return $res;
		}
		public function render()
		{
			$childs=$this->hijos;
			$childsLen=$this->hijosLen;

			for($i=0;$i<$childsLen;$i++)
			{
				$this->importChild($childs[$i]);
			}

			return $this;
		}
		public function renderChilds(&$doc , &$tag)
		{
			//echo '<pre>DOMTagContainer::renderChilds()</pre>';

			if($doc!==null)
			{
				$this->importDoc($doc);
			}
			else
			{
				$this->createDoc();
			}
			if($tag!==null)
			{
				$this->importTag($tag);
			}
			else
			{
				$this->createTag();
			}
/*
			$tName='Doc';
			if(isset($this->tag->tagName))
			{
				$tName=$this->tag->tagName;
			}
			echo '<pre>DOMTagContainer::renderChilds()';
			echo 'Tag: '.$tName;
			echo '</pre>';
*/

			return  $this->render();
		}
		public function importDoc($doc)
		{
			//echo '<pre>DOMTagContainer::importDoc()';echo '</pre>';
			$this->domDoc=$doc;
		}
		public function importTag($tag)
		{
/*
			$tName='Doc';
			if(isset($tag->tagName))
			{
				$tName=$tag->tagName;
			}
			echo '<pre>DOMTagContainer::importTag()'.$tName;echo '</pre>';
*/
			$this->tag=$tag;
		}
		public function createDoc()
		{
			//echo '<pre>DOMTagContainer::createDoc()';echo '</pre>';
			$this->domDoc=new DOMDocument();
		}
		public function getHTML()
		{
			//echo '<pre>DOMTagContainer::getHTML()';
			//echo '</pre>';

			$this->renderChilds($jj=null , $hh=null);

			$innerHTML = ""; 
			$children  = $this->domDoc->childNodes;

			//echo '<pre>ChildNodes:';
			//print_r
			//(
			//	$children
			//);
			//echo '</pre>';

			foreach ($children as $child) 
			{
				$innerHTML .= $this->domDoc->saveHTML($child);
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
		public function createTag()
		{
			//echo '<pre>DOMTagContainer::createTag()';echo '</pre>';

			$this->importTag($this->domDoc);
		}
	}
?>