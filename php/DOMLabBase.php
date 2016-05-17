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
		}
		function resetNodosCol()
		{
			unset( $this->nodosCol );
			//$this->nodosCol=[ 'xs'=> 12 , 'sm'=> 12 , 'md'=> 12 , 'lg'=> 12 ];
		}
		public function appendNodo($nodo)
		{
			$nVal=12 / 
			(
				(
					$this->nodos - 3*intVal
					(
						($this->nodos) / 3
					)
				)+1
			);

			++$this->nodos;

			$nodo->col=&$this->nodosCol;

			$this->nodosCol=[ 'xs'=> 12 , 'sm'=> $nVal , 'md'=> $nVal , 'lg'=> $nVal ];

			if( $this->nodos % 3 === 0)
			{
				$this->resetNodosCol();
			}

			//Agrego dimensiones Bootstrap a cada hijo.
			//$nodosCol=$this->nodosCol;
			
			return parent::appendChild($nodo);
		}
		public function renderChilds(&$tag)
		{
			return parent::renderChilds($tag);
		}
		public function renderChild(&$child)
		{
			return parent::renderChild($child);
		}
	}
?>