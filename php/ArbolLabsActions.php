<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/ArbolActions.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabUl.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabLi.php';

	class ArbolLabsActions implements ArbolActions
	{
		public $firstNode;
		public $initialNode;

		public function __construct($initialNode)
		{
			$this->firstNode=false;
			$this->initialNode=$initialNode;
		}
		public function onNewNode()
		{
			if($this->firstNode===false)
			{
				$this->firstNode=true;
				return $this->initialNode;
			}
			return new DOMLabUl();
		}
		public function onNewChild($child , $newNode)
		{
			$li=new DOMLabLi
			(
				getTraduccion($child['NombreID'] , $_SESSION['lang']),
				$child['Color']
			);
			if(isset($_SESSION['adminID']))
			{
				$li->appendChild
				(
					new FormCliLab($child['ID'])
				);
			}
			$newNode->appendNodo($li);

			return $li;
		}
		public function onHasChilds($newChild , $newNode)
		{
			$newChild->appendNodo($newNode);
		}
	}
?>