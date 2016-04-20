<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';
	
	class DOMVerMas extends DOMTag
	{
		function __construct($url , $name)
		{
			parent::__construct('div');

			$this->addToAttribute('class' , 'DOMVerMas');

			$link=new DOMLink();
			
			$link->addToAttribute('class' , 'focuseable');

			$this->appendChild
			(
				$link->setUrl($url)->setName($name)
			);
		}
	}
?>