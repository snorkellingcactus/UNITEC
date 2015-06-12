<?php
	/**
	* 
	*/
	class Include_Context
	{
		private $ruta;
		public $data;

		function __construct($ruta)
		{
			$this->ruta=$ruta;

			$this->data=array();
		}

		function getContent($ruta=null)
		{
			if($ruta===NULL)
			{
				$ruta=$this->ruta;
			}
			
			include($ruta);
		}

		function getAsText()
		{
			ob_start();
			include($this->ruta);

			$buff=ob_get_contents();
			ob_clean();

			return $buff;
		}

		public function __set($nombre , $valor)
		{
			if(isset($this->$nombre))
			{
				$this->$nombre=$valor;
			}

			$this->data[$nombre]=$valor;
		}

		public function __get($nombre)
		{
			if(isset($this->$nombre))
			{
				return $this->$nombre;
			}

			return $this->data[$nombre];	
		}
	}
?>