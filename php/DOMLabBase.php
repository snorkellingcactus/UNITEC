<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMLabBase extends DOMTag
	{
		public $nodos;
		public $nodosCol;

		function __construct()
		{
			call_user_func_array
			(
				['parent','__construct'],
				func_get_args()
			);

			$this->nodos=0;
			$this->nodosCol=false;
		}
		public function appendNodo($nodo)
		{
			++$this->nodos;
			
			return parent::appendChild($nodo);
		}
		public function renderChilds(&$tag)
		{
			if($this->nodos>1)
			{
				$this->nodosCol=12/$this->nodos;
			}

			return parent::renderChilds($tag);
		}
		public function importChild($child)
		{
			//Agrego dimensiones Bootstrap a cada hijo.
			$nodosCol=$this->nodosCol;

			if($child instanceof DOMTag && $nodosCol!==false)
			{
				$child->col=
				[
					'xs'=>12,
					'sm'=>$nodosCol,
					'md'=>$nodosCol,
					'lg'=>$nodosCol
				];
			}

			return parent::importChild($child);
		}
	}
?>