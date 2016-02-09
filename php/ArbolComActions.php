<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/ArbolActions.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHiloComentario.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMComentario.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliBtnRes.php';

	class ArbolComActions implements ArbolActions
	{
		private $lastName;
		private $formBuilder;
		private $mainDiv;
		private $firstLoop;
		private $raizID;

		function __construct($formBuilder , $raizID , $mainTag)
		{
			$this->mainTag=$mainTag;
			$this->formBuilder=$formBuilder;

			$this->raizID=$raizID;

			$this->lastName=false;
			$this->firstLoop=true;
		}
		public function onNewNode()
		{
			if($this->firstLoop===true)
			{
				$this->firstLoop=false;	
				$nHilo=$this->mainTag;
			}
			else
			{
				$nHilo=new DOMHiloComentario();
			}

			return $nHilo;
		}
		public function onNewChild($child , $newNode)
		{
			$comentario=new DOMComentario();

			if($this->formBuilder!==false)
			{
				$comentario->setCheckBox
				(
					$this->formBuilder->buildActionCheckBox
					(
						$child['ContenidoID']
					)
				);
			}

			$comentario->setContenido
			(
				getTraduccion
				(
					$child['ContenidoID'],
					$_SESSION['lang']
				)
			)->setBtnRes
			(
				new FormCliBtnRes
				(
					$this->raizID,
					$child['ContenidoID']
				)
			)->setNombre
			(
				$child['Nombre']
			)->setFecha
			(
				$child['Fecha']
			);

			$newNode->appendChild($comentario);

			return $comentario;
		}
		public function onHasChilds($newChild , $newNode)
		{
			$newChild->appendNHilo
			(
					$newNode->setName($newChild->nombre)
			);
		}
	}
?>