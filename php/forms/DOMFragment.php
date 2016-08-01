<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	
	//Cambiar a futuro los nombres con XML por HTML
	class DOMFragment extends DOMTagContainer
	{
		private $innerXML;

		public function __construct( $innerHTML )
		{
			$this->setInnerXML( $innerHTML );
		}
		public function renderChilds(&$tag)
		{
			/*
				http://stackoverflow.com/questions/12376686/php-dom-append-html-to-existing-document-without-domdocumentfragmentappendxml

				Error con utf-8 solucionado gracias al capo de http://php.net/manual/es/domdocument.loadhtml.php
			*/
			parent::renderChilds($tag);

			$hdoc=new DOMDocument('1.0' , 'UTF-8');
			$hdoc->loadHTML( '<?xml encoding="UTF-8">' .'<div id="domtohtml">'.$this->innerXML.'</div>' , LIBXML_COMPACT );

			$childs=$hdoc->getElementById('domtohtml')->childNodes;
			$childsLen=$childs->length;

			$owner=$this->getOwnerDocumentOf( $this->getTag() );

			for($i=0;$i<$childsLen;$i++)
			{
				$this->getTag()->appendChild
				(
					$owner->importNode
					(
						$childs->item($i) ,
						true
					)
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