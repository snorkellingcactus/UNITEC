<?php
	class SrvStepRouter
	{
		public $ancla;
		public $dir;


		private $referer;

		private $stepDesp;
		private $steps;
		private $actionUrl;
		private $formDir;
		private $history;
		private $historyLen;

		public $vPressed;
		public $cPressed;

		function __construct()
		{
			//Sacar lo que se necesite de acá, es ridiculo hacer referencia localmente a
			//una variable que se puede referenciar donde sea.

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';

			start_session_if_not();

			if(!isset($_SESSION['referer']))
			{
				$_SESSION['referer']=$_SERVER['HTTP_REFERER'];
			}
			
			$this->referer=$_SESSION['referer'];

			$this->vPressed=false;
			$this->cPressed=false;

			if(isset($_POST['Continuar']))
			{
				$this->cPressed=true;
			}
			if(isset($_POST['Volver']))
			{
				$this->vPressed=true;
			}

			if(isset($_POST['lab']))
			{
				$_SESSION['lab']=$_POST['lab'][0];
			}
			
			if(!isset($_SESSION['form']) && isset($_POST['form']))
			{
				$_SESSION['form']=$_POST['form'][0];
			}
			if(!isset($_SESSION['form']) && !isset($_POST['form']) && isset($_GET['form']))
			{
				$_SESSION['form']=addslashes($_GET['form'][0]);
			}

			$this->ancla='#targeted';

			$this->actionUrl='http://'.$_SERVER['SERVER_NAME'].'/php/accion.php';
			//$this->formDir=$_SERVER['DOCUMENT_ROOT'] . '/forms/config/'.$_SESSION['form'].'.d/';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Desplazador.php';

			$desp=$this->stepDesp=new Desplazador(0,false);

			$this->setFormDir($_SESSION['form']);

			if(isset($_GET['step']))
			{
				$desp->getIndexN(intVal($_GET['step']));
			}
				

			if(!isset($_SESSION['HISTORY']))
			{
				$_SESSION['HISTORY']=[-1];
			}

			$this->historyLen=count($_SESSION['HISTORY']);

			if($this->vPressed)
			{
				if(isset($_SESSION['HISTORY'][$this->historyLen-2]))
				{
					$this->redirectToStepN
					(
						$_SESSION['HISTORY'][$this->historyLen-2]
					);
				}
				else
				{
					$this->gotoOrigin();
				}
			}

			$nStep=$desp->getRelIndexN(0);

			if($_SESSION['HISTORY'][$this->historyLen-1] !== $nStep)
			{
				$_SESSION['HISTORY'][$this->historyLen]=$nStep;
			}
			else
			{
				//Recarga de página.
			}

			$this->invokeStepNumber
			(
				$nStep
			);
		}
		public function setFormDir($formDir)
		{
			$this->formDir=$_SERVER['DOCUMENT_ROOT'] . '/forms/config/'.$formDir.'.d/';

			$_SESSION['steps']=scandir
			(
				$this->formDir,
				SCANDIR_SORT_ASCENDING
			);

			array_shift($_SESSION['steps']);
			array_shift($_SESSION['steps']);

			$this->steps=$_SESSION['steps'];

			$this->stepDesp->setMax(count($this->steps));
		}
		public function newStepFormatter()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/StepNameFormatter.php';
			
			return new StepNameFormatter($this->formDir , $this->actionUrl);
		}
		public function getRelStepN($inc)
		{
			if($this->stepDesp->currentIsLast())
			{
				//echo '<pre>Is The Last</pre>';
				return $this->getOriginUrl();
			}

			$index=$this->stepDesp->getRelIndexN($inc);

			if($inc<0 && $index<=0)
			{
				return $this->getOriginUrl();
			}
			
			return $this->newStepFormatter()->setNumber
			(
				$index
			)->getClientUrl();
		}
		public function getNextStepUrl()
		{
			return $this->getRelStepN(1);
		}
		public function getPrevStepUrl()
		{
			return $this->getRelStepN(-1);
		}
		public function redirect($url)
		{
			header('Location: '.$url);
			die();
		}
		public function redirectToStepN($num)
		{
			if($num<0)
			{
				$this->gotoOrigin();
			}
			$this->redirect
			(
				$this->newStepFormatter()->setNumber
				(
					$this->stepDesp->getIndexN($num)
				)->getClientUrl()
			);
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
			return $this->newStepFormatter()->setNumber
			(
				array_search
				(
					$name ,
					$this->steps
				)
			)->getClientUrl();
		}
		public function getOriginUrl()
		{
			return $this->referer.$this->ancla;
		}
		public function gotoOrigin()
		{
			$this->redirect
			(
				$this->getOriginUrl()
			);
		}
		public function invokeStepNumber($nStep)
		{
			$nStep=$this->stepDesp->getIndexN($nStep);

			$stepFmt=$this->newStepFormatter()->setFileName
			(
				$this->steps[$nStep]
			)->setNumber
			(
				$nStep
			);

			$classPath=$stepFmt->getLocalUrl();
			$className=$stepFmt->getFormattedName();

			include $classPath;

			$step=new $className();
			
			$step->setRouter($this);
		}
	}
?>