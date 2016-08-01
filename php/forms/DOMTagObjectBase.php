<?php
	class DOMTagObjectBase
	{

		function __construct()
		{
			$this->tag=false;
		}

		public function &getTag()
		{
			return $this->tag;
		}
		public function DOMAppendChild( $tag )
		{
//			echo '<pre>'.$this->tag->nodeName.'::appendChild('.$tag->getTag()->nodeName.')'; echo '</pre>';
			$this->tag->appendChild( $tag->getTag() );
		}
	}
?>