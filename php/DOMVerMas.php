<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	
	class DOMVerMas extends DOMTag
	{
		function __construct($url , $name)
		{
			parent::__construct('div');

			$this->addToAttribute('class' , 'DOMVerMas');

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';

			$link=new DOMLink();
			
			$link->addToAttribute('class' , 'focuseable');

			$this->appendChild
			(
				$link->setUrl(getLabUrl(getLabName($_SESSION['lab'])).$url)->setName($name)
			);
		}
	}
?>