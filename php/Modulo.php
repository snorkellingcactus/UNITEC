<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/ModuloBase.php';

	class Modulo extends ModuloBase
	{
		function __construct()
		{
			parent::__construct('div');

			$this->classList->add('Modulo');
		}
		function appendForm($form)
		{
			$this->setAddSep(true);

			return parent::appendForm($form);
		}
	}
?>