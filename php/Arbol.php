<?php
	class Arbol
	{
		public $actions;

		public $main;
		public $dep;
		public $mLen;

		function __construct( $actions )
		{
			$this->actions=$actions;

			$this->dep=array();
			$this->main=array( 0 );
			$this->mLen=&$this->main[0];

		}
		protected function onNewNode()
		{
			return $this->actions->onNewNode();
		}
		protected function onNewChild($child , $newNode)
		{
			return $this->actions->onNewChild( $child ,  $newNode );
		}
		protected function onHasChilds( $newChild , $newNode )
		{
			return $this->actions->onHasChilds( $newChild , $newNode );
		}

		protected function solve_new_node( $index , $data )
		{
			$this->dep[ $index ]=[ $data , [ 0 ] ];
		}
		protected function solve_set_data( $index , $data )
		{
			$this->dep[ $index ][ 0 ]=$data;
		}
		protected function solve_add_child( $parent_index , $child_index )
		{
			$childs=& $this->dep[ $parent_index ][1];

			$count=&$childs[0];

			$childs[ ++$count ]=$child_index;
		}
		protected function solve_has_node( $index )
		{
			return isset( $this->dep[ $index ] );
		}
		protected function solve_process_child( $data , $node_index , $parent_index , $main_index )
		{
			if( $this->solve_has_node( $node_index ) )
			{
				$this->solve_set_data( $node_index , $data );
			}
			else
			{
				$this->solve_new_node( $node_index ,  $data );
			}

			if( $parent_index == $main_index )
			{
				$this->main[ ++$this->mLen ] = $node_index;
			}
			else
			{
				if( !$this->solve_has_node( $parent_index ) )
				{
					$this->solve_new_node( $parent_index ,  NULL );
				}

				$this->solve_add_child( $parent_index , $node_index );
			}
		}
		public function solveDeps( $sqlArray , $parentKey , $childKey , $main_index )
		{
			$i=0;
			while( isset( $sqlArray[$i] ) )
			{
				$data=$sqlArray[$i];

				$this->solve_process_child( $data , $data[$childKey] , $data[$parentKey] , $main_index );


				++$i;
			}

			return $this;
		}
		public function render()
		{
			return $this->renderLoop( $this->main , $this->dep );
		}
		public function renderLoop( &$main , &$dep )
		{
			$newNode=$this->onNewNode();

			$max= &$main[0];

			for( $i = 1 ; $i <= $max ; ++$i )
			{
				$ramas=& $dep[ $main[ $i ] ];

				$newChild=$this->onNewChild( $ramas[0] , $newNode );

				$childs=&$ramas[1];

				if( $childs[0] !== 0 )
				{
					$this->onHasChilds
					(
						$newChild,
						$this->renderLoop( $childs , $dep )
					);
				}
			}

			return $newNode;
		}
	}
?>