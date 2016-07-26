<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMHiloComentario extends DOMTag
	{
		public $name;

		function __construct()
		{
			parent::__construct('div');

			$this->setName( false );

			$this->addToAttribute('class' , 'nHilo');
		}
		function setName($name)
		{
			$this->name=$name;

			return $this;
		}
		function renderChild( &$child )
		{
			if($child instanceof DOMComentario)
			{
				$child->setRemitente
				(
					$this->name
				);
			}

			return parent::renderChild( $child );
		}
	}

?>