<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMHiloComentario extends DOMTag
	{
		public $name;

		function __construct()
		{
			parent::__construct('div');

			$this->setName(false);

			$this->classList->add('nHilo');
		}
		function setName($name)
		{
			$this->name=$name;

			return $this;
		}
		function importChild($com)
		{
			return parent::importChild
			(
				$com->setRemitente
				(
					$this->name
				)
			);
		}
	}

?>