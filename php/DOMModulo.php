<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMModuloBase.php';

	class DOMModulo extends DOMModuloBase
	{
		function __construct()
		{
			parent::__construct('div');

			$this->addToAttribute('class' , 'Modulo');
		}
		function appendForm($form)
		{
			$this->setAddSep(true);

			return parent::appendForm($form);
		}
	}
?>