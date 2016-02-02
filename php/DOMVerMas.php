<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';
	
	class DOMVerMas extends DOMTag
	{
		function __construct($url , $name)
		{
			parent::__construct('div');

			$this->classList->add('DOMVerMas');

			$link=new DOMLink();

			$this->appendChild
			(
				$link->setUrl($url)->setName($name)
			);
		}
	}
?>