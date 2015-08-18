<?php
	class Desplazador
	{
		public $max;
		public $circular;
		public $siguiente;
		public $anterior;

		private $fin;
		public $actual;

		public function __construct($max , $circular)
		{
			$this->max=$max;
			$this->circular=$circular;

			$this->fin=false;
		}
		//Me aseguro que el número dado sea un indice sea valido.
		function indexRecN($num)
		{
			$max=$this->max;

			$this->fin=false;

			if($max===0)
			{
				return 0;
			}

			if($num===$max)
			{
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
		public function get()
		{
			return $this->actual=$this->indexRecN($this->actual);
		}
		public function getNext()
		{
			return $this->siguiente=$this->indexRecN($this->actual+1);
		}
		public function getPrev()
		{
			return $this->anterior=$this->indexRecN($this->actual-1);
		}
		public function set($actual)
		{
			$this->actual=$actual;

			$this->get();
			$this->getNext();
			$this->getPrev();
		}
	}
?>