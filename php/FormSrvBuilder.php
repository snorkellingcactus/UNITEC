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
		public $colDef;
		public $col;
		public $dir;
		public $contador;
		public $conIDAct;

		private $stepDesp;
		private $steps;

		function __construct($fId=NULL , $actions=NULL)
		{
			//Sacar lo que se necesite de acá, es ridiculo hacer referencia localmente a
			//una variable que se puede referenciar donde sea.
			parent::__construct($fId , $actions);

			$this->includes=[];
			$this->colDef=['xs'=>12,'sm'=>8,'md'=>8,'lg'=>8];

			$this->ancla="#nCon";

			$this->cantidad=1;
			$this->contador=0;
			$this->dir=$_SERVER['DOCUMENT_ROOT'] . '/forms/config/'.$_POST['form'].'.d/';

			if(isset($_POST['cantidad']))
			{
				$this->cantidad=intVal($_POST['cantidad']);
			}

			if(isset($_POST['conID']) && isset($_POST['conID'][0]))
			{
				$this->cantidad=count($_POST['conID']);
			}

			$this->setConIDAct();

			$desp=$this->stepDesp=new Desplazador(0,0,false);

			if(!isset($_GET['step']) || !isset($_SESSION['steps']))
			{
				$_SESSION['steps']=scandir
				(
					$this->dir,
					SCANDIR_SORT_ASCENDING
				);

				array_shift($_SESSION['steps']);
				array_shift($_SESSION['steps']);
				$this->steps=$_SESSION['steps'];

				$this->stepUrl=$_SESSION['stepUrl']=$_SESSION['steps'][0];

				$desp->actual=0;
			}
			else
			{
				$desp->actual=$_GET['step'];
			}

			$desp->max=count($this->steps);
		}
		function setConIDAct()
		{
			if(isset($_POST['conID'][$this->contador]))
			{
				$this->conIDAct=$_POST['conID'][$this->contador];
			}
		}
		public function getConfig()
		{
			include $this->dir.$this->steps[$this->stepDesp->indexRecN($this->stepDesp->actual)];
		}
		public function buildIncludes()
		{
			include $_SERVER['DOCUMENT_ROOT'] . '/php/head_include.php';

			$iMax=count($this->includes);

			for($i=0;$i<$iMax;$i++)
			{
				//echo '<pre>Include'.$this->includes[$i].'</pre>';
				head_include($this->includes[$i]);
			}
			unset($iMax);
		}
		public function mkCol()
		{
			$buff='';

			foreach($this->col as $clave=>$valor)
			{
				$buff.=' col-'.$clave.'-'.$valor;
			}
			return $buff;
		}
		public function buildForm()
		{

			/*
			$lMax=count($this->labels);

			$buff='';
			for($l=0;$l<$lMax;$l++)
			{
				$this->col=$this->colDef;
				$labelAct=$this->labels[$l];

				$tipo=$labelAct[0];
				$labelName=$labelAct[1];

				ob_start();
				
				?>
					<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<label for="<?php echo $labelName ?>"><?php echo $labelName ?>:</label>
					</p>

					<?php include $_SERVER['DOCUMENT_ROOT'] . '//forms/'.$tipo; ?>

					<div class="clearfix"></div>

				<?php

				$buff=$buff.ob_get_contents();
				ob_end_clean();
			}

			unset($l , $labelName , $labelAct , $labels);

			return $buff;
			*/
		}

		public function buildNext()
		{
			$this->setConIDAct();
			
			include $this->dir.$this->steps[$this->stepDesp->indexRecN($this->stepDesp->actual)];

			echo $this->form->getHTML();
			++$this->contador;
		}
	}
?>