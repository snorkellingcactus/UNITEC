<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepFormBase.php';

	class SrvStepRepeatedForm extends SrvStepFormBase
	{
		private $cantidad;
		private $contador;
		private $omitFirst;

		private $includes;

		function __construct()
		{
			//Revisar contexto adecuado.
			if(isset($_POST['cantidad']))
			{
				$_SESSION['cantidad']=intVal($_POST['cantidad'][0]);
			}
			//Revisar.
			if(isset($_POST['conID'][0]))
			{
				$_SESSION['cantidad']=count($_POST['conID']);
			}
			if(isset($_SESSION['cantidad']))
			{
				$this->cantidad=intVal($_SESSION['cantidad']);
			}
			else
			{
				$this->cantidad=1;
			}

			$this->includes=[];
			$this->contador=0;

			parent::__construct();
		}
		public function makeLabels()
		{
			//Returns LabelsCollection
			return parent::makeLabels()->setIndex($this->contador);

			echo '<pre>SetIndex( '.$this->contador.' )';
			echo '</pre>';
		}
		public function thisIsLast()
		{
			if($this->contador===$this->cantidad-1)
			{
				return true;
			}
			return false;
		}
		public function thisIsFirst()
		{
			if($this->contador===0)
			{
				return true;
			}
			return false;
		}
		public function hasNext()
		{
			return $this->contador<$this->cantidad;
		}
		public function increment()
		{
			++$this->contador;
		}
		public function getCount()
		{
			return $this->contador;
		}
	}
?>