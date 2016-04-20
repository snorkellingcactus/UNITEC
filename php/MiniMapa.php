<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';

	//Revisar. Role Navigation?
	class MiniMapa extends DOMTag
	{
		public $i;
		public $eLen;

		function __construct()
		{
			parent::__construct('nav');

			$this->i=new DOMTag('i');
			$this->i->addToAttribute('class' , 'minimapa');

			$this->eLen=0;

			$labs=explode
			(
				',',
				getLabTagTree($_SESSION['lab'])
			);

			$len=count($labs);

			for($i=$len;$i>0;$i--)
			{
				$lName=trim($labs[$i-1]);

				$this->appendEntry
				(
					$this->newEntry
					(
						$lName,
						getLabUrl($lName)
					)
				);
			}

			$this->appendChild($this->i);
		}
		function newEntry($name , $url)
		{
			$link=new DOMLink();

			$link->addToAttribute('class' , 'focuseable');

			return $link->setName($name)->setUrl($url);
		}
		function appendEntry($entry)
		{
			if($this->eLen>0)
			{
				$this->addSep();
			}

			++$this->eLen;

			$this->i->appendChild($entry);

			return $this;
		}
		function addSep()
		{
			$this->i->appendChild($this->newSep());

			return $this;
		}
		function newSep()
		{
			return new DOMTag
			(
				'span',
				htmlentities(' > ')
			);
		}
	}
?>