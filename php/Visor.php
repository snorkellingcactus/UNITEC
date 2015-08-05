<?php

class Visor
{
	public	$recLst=[];
	private $recMax=0;
	public	$nRecSel=NULL;		//Número de Imagen coincidente con el valor del discriminador.
	public	$recSel=false;		//Objeto imagen seleccionado.
	private	$include;
	public	$disc=['ID'=>false];	//Propiedades discriminadoras a la hora de determinar una imagen para el visor.
	public	$discNum=false;
	public $fin=false;

	public function __construct($recLst=false , $include=false)
	{
		//Si todavía no se inicio sesion, se inicia.
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
		start_session_if_not();

		$this->include=$include;
		$this->recLst=$recLst;

		//Si se especificó un ID de imagen, se selecciona esa imagen para mostrar
		//Temporal. En el futuro utilizar solo vRec
		if(isset($_POST['vRecID']))
		{
			$_SESSION['vRecID']=intval($_POST['vRecID']);
		}
		//Si se especificó un ID de imagen, se selecciona esa imagen para mostrar
		if(isset($_GET['vRecID']))
		{
			$_SESSION['vRecID']=intval($_GET['vRecID']);
		}
		//Variable con el numero de imagen que se va a mostrar.
		if(isset($_GET['vRec']))
		{
			$this->discNum=$_GET['vRec'];			//Indico el número de imagen a desplegar.
		}
		if(isset($_SESSION['vRecID']))
		{
			$this->disc['ID']=$_SESSION['vRecID'];
		}
		if($this->recSel!==false)
		{
			$this->getContent();
		}
	}
	function gen($include=false)
	{
		if($include!==false)
		{
			$this->include=$args[0];
		}

		$esq=$this->recSel;

		include($this->include);
	}

	//Setea el n de imagen que despliega el visor impidiendo errores con
	//números fuera de rango.
	function selRecN($num)
	{
		$this->nRecSel=$this->indexRecN($num);

		$this->recSel=& $this->recLst[$this->nRecSel];

		global $vRecID;

		$_SESSION['vRecID']=$vRecID=$this->recSel['ID'];

		return $this->nRecSel;
	}
	//Me aseguro que el número dado sea un indice sea valido.
	function indexRecN($num)
	{
		$max=count($this->recLst);

		$this->fin=false;

		if($max===0)
		{
			return 0;
		}

		if($num===$max)
		{
			$this->fin=true;
		}

		$nRecSel=abs($num-intval($num/$max)*$max);

		if($num<0)
		{
			$nRecSel=$max-$nRecSel;
		}

		return $nRecSel;
	}
	//Devuelve el objeto almacenado en la posición especificada.
	function RecN($num)
	{
		return $this->recLst
		[
			$this->indexRecN($num)
		];
	}
	//Discrimina un objeto imagen segun el resultado de compararla con los valores de $this->disc.
	function discRec($nRec)
	{
		$rec=$this->recLst[$nRec];
		$disc=true;
	
		if($this->discNum!==false)
		{
			if($nRec!=$this->discNum)
			{
				$disc=false;
			}
		}
		else
		{
			$props=$this->disc;	
			//Si alguno de los valores es distinto no se selecciona.
			foreach($props as $clave => $valor)
			{
				if($rec[$clave]!=$valor)
				{
					$disc=false;
					break;
				}
			}
		}

		if($disc)
		{
			$this->selRecN($nRec);
			return 1;
		}
		return 0;
	}
	function discRecLst()
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
	function addRec($rec)
	{
		$this->recLst[$this->recMax]=$rec;

		++$this->recMax;

		return $this->discRec($this->recMax-1);
	}
	function getContent()
	{
		if(!isset($this->recLst[0]))
		{
			$this->discRecLst();
		}
		if($this->recSel===false)
		{
			$this->selRecN(0);
		}
		$this->include->data=$this->recSel;

		$this->include->vRecSig=$this->indexRecN($this->nRecSel+1);
		$this->include->vRecAnt=$this->indexRecN($this->nRecSel-1);

		$this->include->getContent();
	}
}
?>