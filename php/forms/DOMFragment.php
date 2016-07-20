<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	
	//Cambiar a futuro los nombres con XML por HTML
	class DOMFragment extends DOMTagBase
	{
		private $innerXML;

		public function __construct($inner)
		{

			$this->setInnerXML($inner);
		}
		public function renderChilds(&$tag)
		{
			parent::renderChilds($tag);

			$hdoc=new DOMDocument( '1.0' , 'UTF-8');
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
		public function newTag()
		{
			$fragment=$this->getOwnerDocumentOf
			(
				$this->parent->getTag()
			)->createDocumentFragment();

			$fragment->appendXML
			(
				html_entity_decode
				(
					$this->innerXML
				)
			);
			return $fragment;
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