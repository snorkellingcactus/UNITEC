<?php
	class Desplazador
	{
		private $max;
		private $circular;

		private $fin;
		private $actual;

		public function __construct($max , $circular)
		{
			$this->max=$max;
			$this->circular=$circular;

			$this->actual=0;

			$this->fin=false;
		}
		//Me aseguro que el número dado sea un indice sea valido.
		private function indexN($num)
		{
			$max=$this->max;

			$this->fin=false;

			if($max===0)
			{
				return 0;
			}

			if($num===$max-1)
			{
				//echo '<pre>Is The Last</pre>';
				$this->fin=true;
			}

			$nRecSel=abs($num-intVal($num/$max)*$max);

			if($num<0)
			{
				if($this->circular===true)
				{
					$nRecSel=$max-$nRecSel;
				}
				else
				{
					$nRecSel=$max;
				}
			}

			return $nRecSel;
		}
		private function getIndex($index)
		{
			return $this->indexN($index);
		}
		private function getRelIndex($inc)
		{
			return $this->getIndex($this->actual+$inc);
		}
		public function thisIsLast()
		{
			return $this->actual===$this->max-1;
		}
		public function getIndexN($index)
		{
			return $this->actual=$this->getIndex($index);
		}
		public function getRelIndexN($inc)
		{
			return $this->actual=$this->getRelIndex($inc);
		}
		public function getNext()
		{
			return $this->getRelIndex(1);
		}
		public function getPrev()
		{
			return $this->getRelIndex(-1);
		}
		public function currentIsLast()
		{
			return $this->fin;
		}
		public function setMax($max)
		{
			$this->max=$max;

			return $this;
		}
	}
?>