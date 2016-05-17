<?php
	class Arbol
	{
		public $actions;

		public $main;
		public $dep;
		public $mLen;

		function __construct($actions)
		{
			$this->actions=$actions;

			$this->main=array();
			$this->dep=array();
			$this->mLen=0;
		}
		public function solveDeps($sqlArray , $parentKey , $childsKey , $parentVal)
		{
			$dep=&$this->dep;
			$main=&$this->main;

			$i=0;
			while(isset($sqlArray[$i]))
			{
				$fila=$sqlArray[$i];

				$padreID=$fila[$parentKey];
				$hijoID=$fila[$childsKey];

				//echo '<pre>Padre : '.$padreID.' ; Contenido : '.$conID.'</pre>';
				if(!isset($dep[$hijoID]))
				{
					$dep[$hijoID]=[$fila,[]];
				}
				else
				{
					$dep[$hijoID][0]=$fila;
				}

				if($padreID==$parentVal)
				{
					$main[$this->mLen]=$hijoID;
					++$this->mLen;
				}
				else
				{
					if(!isset($dep[$padreID]))
					{
						$dep[$padreID]=[false,[$hijoID]];
					}

					$depAct=& $dep[$padreID][1];

					$depAct[count($depAct)]=$hijoID;
				}

				++$i;
			}

			return $this;
		}
		public function render()
		{
			return $this->renderLoop($this->main , $this->dep);
		}
		public function renderLoop($main , $dep)
		{
			$newNode=$this->actions->onNewNode();

			$i=0;
			while( isset( $main[$i] ) )
			{
				$ramas=& $dep[$main[$i]];

				$newChild=$this->actions->onNewChild( $ramas[0] , $newNode );

				$childs=$ramas[1];

				if( isset( $childs[0] ) )
				{
					$this->actions->onHasChilds
					(
						$newChild,
						$this->renderLoop($childs , $dep)
					);
				}
				++$i;
			}
			return $newNode;
		}
	}
?>