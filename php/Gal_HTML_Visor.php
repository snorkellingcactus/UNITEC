<?php
require_once('Obj_Gen_HTML.php');

class	Gal_HTML_Visor
{
	private	$imgLst=[];
	public	$nImgSel=NULL;		//Número de Imagen coincidente con el valor del discriminador.
	public	$imgSel=NULL;		//Objeto imagen seleccionado.
	private	$modHTML;
	private	$disc=['ID'=>0];	//Propiedades discriminadoras a la hora de determinar una imagen para el visor.

	public function __construct($imgLst=false , $con=false)
	{
		$args=func_get_args();

		if(isset($args[1]))
		{
			$this->modHTML=$args[1];
		}
		if(!isset($_SESSION['imgLst']))
		{
			if($con)
			{
				$asocLst=$con->query($imgLst);
				$asocLst=$asocLst->fetch_all(MYSQLI_ASSOC);	//Respuesta SQL como array asociativo.

				$iMax=count($asocLst);

				for($i=0;$i<$iMax;$i++)
				{
					$this->imgLst[$i]=new Img($con,$asocLst[$i]);
				}
			}

			$_SESSION['imgLst']=serialize($this->imgLst);
		}
		else
		{
			$this->imgLst=unserialize($_SESSION['imgLst']);

			//unset($_SESSION['imgLst']);
		}
		//Variable con el numero de imagen que se va a mostrar.
		if(isset($_GET['vImg']))
		{
			$this->selImgN($_GET['vImg']);			//Indico el número de imagen a desplegar.
		}
		//Si se especificó un ID de imagen, se selecciona esa imagen para mostrar
		if(isset($_POST['vImgId']))
		{
			$_SESSION['vImgID']=intval($_POST['vImgId']);
		}
		if(isset($_SESSION['vImgID']))
		{
			$this->disc['ID']=$_SESSION['vImgID'];
			$this->discImgLst();
		}
	}
	function gen()
	{
		$args=func_get_args();
		if(isset($args[0]))
		{
			$this->modHTML=$args[0];
		}

		return $this->modHTML->gen($this->imgSel);
	}

	//Setea el n de imagen que despliega el visor impidiendo errores con
	//números fuera de rango.
	function selImgN($num)
	{
		$this->nImgSel=$this->indexImgN($num);

		$this->imgSel=$this->imgLst[$this->nImgSel];

		$_SESSION['vImgID']=$this->imgSel->ID;

		return $this->nImgSel;
	}
	function indexImgN($num)
	{
		$max=count($this->imgLst);
		
		$nImgSel=abs($num-intval($num/$max)*$max);

		if($num<0)
		{
			$nImgSel=$max-$nImgSel;
		}

		return $nImgSel;
	}
	function ImgN($num)
	{
		return $this->imgLst
		[
			$this->indexImgN($num)
		];
	}
	//Discrimina un objeto imagen segun el resultado de compararla con los valores de $this->disc.
	function discImg($nImg)
	{
		$props=$this->disc;
		$img=$this->imgLst[$nImg];
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
			$this->selImgN($nImg);
			return 1;
		}
		return 0;
	}
	function discImgLst()
	{
		$iMax=count($this->imgLst);

		for($i=0;$i<$iMax;$i++)
		{
			if($this->discImg($i))
			{
				break;
			}
		}
	}
}
?>