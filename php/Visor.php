<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Obj_Gen_HTML.php';

class Visor
{
	private	$recLst=[];
	public	$nRecSel=NULL;		//Número de Imagen coincidente con el valor del discriminador.
	public	$recSel=NULL;		//Objeto imagen seleccionado.
	private	$include;
	private	$disc=['ID'=>0];	//Propiedades discriminadoras a la hora de determinar una imagen para el visor.

	public function __construct($recLst=false , $include=false)
	{
		$args=func_get_args();

		if($include!==false)
		{
			$this->include=$args[1];
		}
		//Variable con el numero de imagen que se va a mostrar.
		if(isset($_GET['vRec']))
		{
			$this->selRecN($_GET['vRec']);			//Indico el número de imagen a desplegar.
		}
		//Si se especificó un ID de imagen, se selecciona esa imagen para mostrar
		if(isset($_POST['vRecId']))
		{
			$_SESSION['vRecID']=intval($_POST['vRecId']);
		}
		//Si se especificó un ID de imagen, se selecciona esa imagen para mostrar
		if(isset($_GET['vRecId']))
		{
			$_SESSION['vRecID']=intval($_GET['vRecId']);
		}
		if(isset($_SESSION['vRecID']))
		{
			$this->disc['ID']=$_SESSION['vRecID'];
			$this->discRecLst();
		}
	}
	function gen($include=false)
	{
		if($include!===false)
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

		$this->recSel=$this->recLst[$this->nRecSel];

		$_SESSION['vRecID']=$this->recSel->ID;

		return $this->nRecSel;
	}
	//Me aseguro que el número dado sea un indice sea valido.
	function indexRecN($num)
	{
		$max=count($this->recLst);
		
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
		return $this->imgLst
		[
			$this->indexRecN($num)
		];
	}
	//Discrimina un objeto imagen segun el resultado de compararla con los valores de $this->disc.
	function discRec($nRec)
	{
		$props=$this->disc;
		$rec=$this->recLst[$nRec];
		$disc=true;
		
		//Si alguno de los valores es distinto no se selecciona.
		foreach($props as $clave => $valor)
		{
			if($rec->$clave!=$valor)
			{
				$disc=false;
				break;
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
		$iMax=count($this->imgLst);

		for($i=0;$i<$iMax;$i++)
		{
			if($this->discRec($i))
			{
				break;
			}
		}
	}
}
?>