<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Desplazador.php';

	class Visor extends Desplazador
	{
		public	$recLst;
		private	$recMax;
		public	$nRecSel;		//Número de Imagen coincidente con el valor del discriminador.
		public	$recSel;		//Objeto imagen seleccionado.
		public	$vRecIDAnt;
		public	$discVal;

		public function __construct()
		{
			parent::__construct(0 , true);

			$this->recLst=[];
			$this->recMax=0;
			$this->nRecSel=NULL;
			$this->recSel=false;
			$this->discVal=false;
			$this->vRecIDAnt=false;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
			start_session_if_not();
	/*
			echo '<pre>SESSION:';
			print_r
			(
				$_SESSION
			);
			echo '</pre>';
	*/
			//Si realizando alguna operación (como comentar)
			//se pierde el ancla, la variable SESSION estará por si acaso.
			if(isset($_SESSION['vRecID']))
			{
				$this->discVal=$_SESSION['vRecID'];
			}
			//Si se especificó un ID de imagen, se selecciona esa imagen para mostrar
			if(isset($_GET['vRecID']))
			{
				$this->discVal=strip_tags($_GET['vRecID']);
			}
		}

		//Setea el n de imagen que despliega el visor impidiendo errores con
		//números fuera de rango.
		function selRecN($num)
		{
			$this->nRecSel=$this->getIndexN($num);

			$this->recSel=& $this->recLst[$this->nRecSel];

			$_SESSION['vRecID']=$this->recSel;

			$this->autoSetRecIDAnt();

			return $this->nRecSel;
		}
		private function autoSetRecIDAnt()
		{
			
				$this->setRecIDAntIfValid($_GET);
			

			$_SESSION['vRecIDAnt']=$this->recSel;
		}
		private function setRecIDAntIfValid($cont)
		{
			if(isset($cont['vRecIDAnt']))
			{
				$vRecIDAnt=strip_tags($cont['vRecIDAnt']);
				//echo '<pre>'.$this->discVal.'!='.$vRecIDAnt.'</pre>';

				if($this->discVal!=$vRecIDAnt)
				{
					$this->vRecIDAnt=$vRecIDAnt;

					return true;
				}
				return false;
			}
		}
		//Devuelve el objeto almacenado en la posición especificada.
		public function RecN($n)
		{
			return $this->recLst
			[
				$this->getIndexN($n)
			];
		}
		//Discrimina un objeto imagen segun el resultado de compararla con los valores de $this->disc.
		public function discRec($nRec)
		{
			$rec=$this->recLst[$nRec];

			//Si alguno de los valores es distinto no se selecciona.
			if($rec==$this->discVal)
			{
				$this->selRecN($nRec);
				return 1;
			}

			return 0;
		}
		public function discRecLst()
		{
			$iMax=count($this->recLst);

			for($i=0;$i<$iMax;$i++)
			{
				if($this->discRec($i))
				{
					break;
				}
			}
		}
		public function addRec($rec)
		{
			$this->recLst[$this->recMax]=$rec;
			//echo '<pre>$this->recLst['.$this->recMax.']=...</pre>';

			++$this->recMax;
			$this->max=$this->recMax;

			return $this->discRec($this->recMax-1);
		}
		public function getContent()
		{
			if(!isset($this->recLst[0]))
			{
				$this->discRecLst();
			}
			if($this->recSel===false)
			{
				$this->selRecN(0);
			}
		}
	}
?>