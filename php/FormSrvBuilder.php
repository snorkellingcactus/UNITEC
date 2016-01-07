<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSrvRecv.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Desplazador.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Form.php';

	class FormSrvBuilder extends FormSrvRecv
	{
		public $ancla;
		public $form;
		public $cantidad;
		public $labels;
		public $dir;
		public $contador;
		public $conIDAct;
		public $omitFirst;

		private $stepDesp;
		private $steps;

		function __construct($fId=NULL , $actions=NULL)
		{
			//Sacar lo que se necesite de acá, es ridiculo hacer referencia localmente a
			//una variable que se puede referenciar donde sea.
			parent::__construct($fId , $actions);

			$this->includes=[];

			$this->ancla="#targeted";

			$this->cantidad=1;
			$this->contador=0;
			$this->firstBuff=NULL;
			$this->dir=$_SERVER['DOCUMENT_ROOT'] . '/forms/config/'.$_SESSION['form'].'.d/';
			$this->actionUrl='http://'.$_SERVER['SERVER_NAME'].'/php/accion.php';
			$this->form=new Form($this);

			if(isset($_SESSION['cantidad']))
			{
				$this->cantidad=intVal($_SESSION['cantidad']);
			}

			if(isset($_POST['conID']) && isset($_POST['conID'][0]))
			{
				$this->cantidad=count($_POST['conID']);
			}

			$this->setConIDAct();

			$desp=$this->stepDesp=new Desplazador(0,false);

			unset($_SESSION['steps']);

			if(!isset($_SESSION['steps']))
			{
				$_SESSION['steps']=scandir
				(
					$this->dir,
					SCANDIR_SORT_ASCENDING
				);

				array_shift($_SESSION['steps']);
				array_shift($_SESSION['steps']);
			}

			$this->steps=$_SESSION['steps'];

			$this->stepUrl=$_SESSION['stepUrl']=$_SESSION['steps'][0];

			$desp->actual=0;

			$desp->max=count($this->steps);

			if(isset($_GET['step']))
			{
				$desp->actual=$_GET['step'];
			}
		}
		public function getNextStepUrl()
		{
			if($this->stepDesp->thisIsLast())
			{
				//echo '<pre>Is The Last</pre>';
				return $this->referrer.$this->ancla;
			}
			return $this->actionUrl.'?step='.$this->stepDesp->getNext();
		}
		public function setConIDAct()
		{
			if(isset($_POST['conID'][$this->contador]))
			{
				$this->conIDAct=$_POST['conID'][$this->contador];
			}
		}
		public function getConfig()
		{
		//	include $this->dir.$this->steps[$this->stepDesp->indexRecN($this->stepDesp->actual)];
		}
		public function getReqs()
		{
			$this->buildNext();

			$this->omitFirst=true;

			return $this->form->getReqs();
		}
		public function buildIncludes()
		{
			//echo '<pre>buildIncludes</pre>';
			include $_SERVER['DOCUMENT_ROOT'] . '/php/head_include.php';

			$iMax=count($this->includes);

			for($i=0;$i<$iMax;$i++)
			{
				//echo '<pre>Include'.$this->includes[$i].'</pre>';
				head_include($this->includes[$i]);
			}
			unset($iMax);
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
		public function buildNext()
		{
			//echo '<pre>buildNext</pre>';
			if($this->omitFirst)
			{
				//echo '<pre>buildNext: El primero';;echo '</pre>';

				$this->omitFirst=false;

				return true;
			}
			else
			{
				if($this->contador>=$this->cantidad)
				{
					//echo '<pre>buildNext: El último</pre>';
					return false;
				}

				//echo '<pre>buildNext: Normal</pre>';
				$this->setConIDAct();
				$this->form->setIDSuffix($this->contador);
			
				include $this->dir.$this->steps[$this->stepDesp->indexRecN($this->stepDesp->actual)];

				++$this->contador;

				return true;
			}
		}
		public function buildAll()
		{
			//echo '<pre>buildAll</pre>';
			$j=0;
			while($this->buildNext())
			{
				++$j;
			}

			return $this;
		}
		public function redirectToStepN($num)
		{
			$this->redirect($this->actionUrl.'?step='.$num);
		}
		public function redirectToStepName($name)
		{
			$this->redirect
			(
				$this->getStepUrlByName($name)
			);
		}
		public function getStepUrlByName($name)
		{
			return $this->actionUrl.'?step='.array_search($name , $this->steps);
		}
		public function getOriginUrl()
		{
			return $this->referrer.$this->ancla;
		}
	}
?>