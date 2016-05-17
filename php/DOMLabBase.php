<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMLabBase extends DOMTag
	{
		public $nodos;
		public $nodosCol;
		public $nodosColValue;

		function __construct()
		{
			call_user_func_array
			(
				['parent','__construct'],
				func_get_args()
			);

			$this->nodos=0;
			$this->resetNodosCol();
		}
		function resetNodosCol()
		{
			unset( $this->nodosCol );
			unset( $this->nodosColValue );

			$this->nodosColValue=12;

			$val=&$this->nodosColValue;

			$this->nodosCol=
			[
				'xs'=> 12 ,
				'sm'=> &$val ,
				'md'=> &$val ,
				'lg'=> &$val
			];
		}
		public function threeMult()
		{
			return $this->nodos % 3 === 0;
		}
		public function calcCols($nodos)
		{
			return $this->nodosColValue=12 / 
			(
				(
					$nodos - 3*intVal
					(
						$nodos / 3
					)
				) + 1
			);
		}
		public function appendNodo($nodo)
		{
			++$this->nodos;

			$nodo->col=&$this->nodosCol;

			if( $this->threeMult() )
			{
				$this->calcCols( $this->nodos -1 );

				$this->resetNodosCol();
			}
			
			return parent::appendChild($nodo);
		}
		public function renderChilds(&$tag)
		{
			if( ! $this->threeMult() )
			{
				$this->calcCols( $this->nodos -1 );
			}
			
			return parent::renderChilds($tag);
		}
		public function renderChild(&$child)
		{
			return parent::renderChild($child);
		}
	}
?>