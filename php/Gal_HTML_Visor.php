<?php
require_once('Obj_Gen_HTML.php');

class	Gal_HTML_Visor
{
	private	$gal;
	private	$nImgSel=NULL;		//Número de Imagen coincidente con el valor del discriminador.
	private	$imgSel=NULL;		//Objeto imagen seleccionado.
	private	$modHTML;
	private	$disc=['ID'=>0];	//Propiedades discriminadoras a la hora de determinar una imagen para el visor.

	public function __construct($gal,$modHTML)
	{
		$this->gal=$gal;
		$this->modHTML=$modHTML;

		//Variable con el numero de imagen que se va a mostrar.
		if(!isset($_SESSION['vImg']))
		{
			$this->selImgN(0);			//Indico el número de imagen a desplegar.
		}
		else
		{
			$this->selImgN($_SESSION['vImg']);
		}
		//Si se pasó un incremento del número de imagen por GET lo aplico.
		if(isset($_GET['vInc']))
		{
			$this->incImgN($_GET['vInc']);
		}
		//Si se especificó un ID de imagen, se selecciona esa imagen para mostrar
		if(isset($_GET['vImgID']))
		{
			$this->disc=['ID'=>$_GET['vImgID']];
		}
	}
	function gen()
	{
		return $this->modHTML->gen($this->imgSel);
	}
	//Desplaza la imagen seleccionada para el visor $inc veces.
	function incImgN($inc)
	{
		$num=$this->nImgSel+$inc;
		return $this->selImgN($num);
	}
	//Setea el n de imagen que despliega el visor impidiendo errores con
	//números fuera de rango.
	function selImgN($num)
	{
		$max=count($this->gal->imgLst);
		
		$this->nImgSel=abs($num-intval($num/$max)*$max);
		if($num<0)
		{
			$this->nImgSel=$max-$this->nImgSel;
		}

		$this->imgSel=$this->gal->imgLst[$this->nImgSel];

		$_SESSION['vImgID']=$this->imgSel->ID;
		$_SESSION['vImg']=$this->nImgSel;

		return $this->nImgSel;
	}
	//Discrimina un objeto imagen segun el resultado de compararla con los valores de $this->disc.
	function discImg($nImg)
	{
		$props=$this->disc;
		$img=$this->gal->imgLst[$nImg];
		$disc=true;
		
		//Si alguno de los valores es distinto no se selecciona.
		foreach($props as $clave => $valor)
		{
			if($img->$clave!=$valor)
			{
				$disc=false;
				break;
			}
		}

		if($disc)
		{
			$this->nImgSel=$nImg;
			$this->imgSel=$img;

			$_SESSION['vImgID']=$this->imgSel->ID;
			$_SESSION['vImg']=$this->nImgSel;
			return 1;
		}
		return 0;
	}
}
class Comentarios
{
	public function __construct()
	{
		
	}
}
?>