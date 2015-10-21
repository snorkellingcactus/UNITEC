<?php
	//Cambiar a futuro los nombres con XML por HTML
	class DOMFragment extends DOMTagContainer
	{
		private $innerXML;

		public function __construct()
		{
			parent::__construct();

			$args=func_get_args();
			if(isset($args[0]))
			{
				$this->setInnerXML($args[0]);
			}
		}
		public function render()
		{
			$hdoc=new DOMDocument();
			$hdoc->loadHTML('<div id="domtohtml">'.$this->innerXML.'</div>');

			$childs=$hdoc->getElementById('domtohtml')->childNodes;
			$childsLen=$childs->length;

			for($i=0;$i<$childsLen;$i++)
			{
				$child=$this->domDoc->importNode($childs->item($i) , true);
				$this->tag->appendChild($child);
			}
			
			return $this;
		}
		public function setInnerXML($xml)
		{
			$this->innerXML=$xml;

			return $this;
		}
		public function getInnerXML()
		{
			return $this->innerXML;
		}
	}
?>