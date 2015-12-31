<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	/*
		Si se invoca a DOMTagBase antes que DOMTag larga error...
	*/

	class SMapUrl extends DOMTagBase
	{
		public $location;
		public $lastMod;
		public $chfreq;
		public $priority;

		public $loc;
		public $lmod;
		public $cfreq;

		function __construct($location)
		{
			parent::__construct('url');

			$this->location=$location;
			$this->lastMod=false;
			$this->chfreq=false;
			$this->priority=false;

			$this->loc=new DOMTag('loc');
			$this->lmod=new DOMTag('lastmod');
			$this->cfreq=new DOMTag('changefreq');
			$this->prior=new DOMTag('priority');

			//Improvisada forma de lograr que se rendericen primero
			//los tags de esta clase antes que los de las clases hijas.

			$this->appendChild
			(
				$this->loc
			)->appendChild
			(
				$this->lmod
			)->appendChild
			(
				$this->cfreq
			)->appendChild
			(
				$this->prior
			);
		}
		public function setLastMod($date)
		{
			$this->lastMod=$date;

			return $this;
		}
		public function setChFreq($chfreq)
		{
			$this->chfreq=$chfreq;

			return $this;
		}
		public function setPriority($priority)
		{
			$this->priority=$priority;

			return $this;
		}
		public function renderChilds(&$doc , &$tag)
		{
			//echo '<pre>SMapUrl::renderChilds';echo '</pre>';
			//echo '<pre>SMapUrl::renderChilds location:';print_r($this->location);echo '</pre>';

			
			$this->loc->setTagValue($this->location);

			if($this->lastMod!==false)
			{
				$this->lmod->setTagValue($this->lastMod);
			}
			if($this->chfreq!==false)
			{
				$this->cfreq->setTagValue($this->cfreq);
			}
			if($this->priority!==false)
			{
				$this->prior->setTagValue($this->priority);
			}

			return parent::renderChilds($doc , $tag);
		}
	}
?>