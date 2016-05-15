<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	
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
		public function renderChilds(&$tag)
		{
			parent::renderChilds($tag);

			$hdoc=new DOMDocument();
			$hdoc->loadHTML('<div id="domtohtml">'.$this->innerXML.'</div>');

			$childs=$hdoc->getElementById('domtohtml')->childNodes;
			$childsLen=$childs->length;

			for($i=0;$i<$childsLen;$i++)
			{
				$this->getTag()->appendChild
				(
					$this->getOwnerDocumentOf($this->getTag())->importNode($childs->item($i) , true)
				);
			}
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