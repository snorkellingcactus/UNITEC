<?php
class Arr_Gen_HTML
{
	private $numVars;
	private	$props;

	function __construct($estructura,$props)
	{
		$this->estructura=$estructura;
		$this->props=$props;

		$this->numVars=count($estructura)-1;
	}
	function gen()
	{
		return $this->recorre($this->props);
	}
	function recorre($obj)
	{

		$buff='';

		$iMax=$this->numVars;

		for($i=0;$i<$iMax;$i++)
		{
			$prop=$this->props[$i];

			//Si se trata de un objeto genHTML lo genero.
			if(is_object($prop))
			{
				$buff=$buff.$this->estructura[$i].$prop->gen();
				continue;
			}
		
			$buff=$buff.$this->estructura[$i].$this->getProp($obj,$prop);
		}

		return $buff.$this->estructura[$iMax];
	}
	//Obtengo la propiedad de un array.
	function getProp($obj , $prop)
	{
		return $prop;
	}
}
class Obj_Gen_HTML extends Arr_Gen_HTML
{
	function __construct($estructura , $props)
	{
		parent::__construct($estructura,$props);
	}
	function gen($obj)
	{
		return $this->recorre($obj);
	}
	//Obtengo la propiedad de un objeto.
	function getProp($obj , $prop)
	{
		return $obj->$prop;
	}
}
//Genera el código HTML de la galería según los parametros dados.
//$img puede ser el texto de una consulta SQL
//o una lista de objetos de tipo Img.
class Gal_HTML
{
	private	$con;
	public	$maxCols=10;
	public	$imgLst=[];
	public	$genVisor=0;
	public	$disc='ID';	//Propiedad discriminadora a la hora de buscar u ordenar las imágenes.
	public  $discVal=0;	//Valor del discriminador.
	public	$imgSel=NULL;	//Imagen coincidente con el valor del discriminador.
	public	$modGal;
	public	$modVisor;
	
	function __construct($img)
	{
		$args=func_get_args();
		$nArgs=0;

		if(gettype($img)==='string')
		{
			$nArgs=$nArgs+1;
			$this->getSQL($img,$args[1]);	//Si era un string se trata de una consulta, la proceso.
		}
		else
		{
			$this->imgLst=$img;	//Sino era una lista de objetos Img, la guardo.
		}

		if(isset($args[$nArgs+1]))
		{
			$this->modGal=$args[$nArgs+1];
		}
		if(isset($args[$nArgs+2]))
		{
			$this->visorMod($args[$nArgs+2]);
		}
	}
	function nImg($img)
	{
		$index=count($this->imgLst);
		$this->imgLst[$index]=$img;
	}
	function gen()
	{
		$buff='';
		$iMax=count($this->imgLst);
		
			
		for($i=0;$i<$iMax;$i++)
		{
			if(isset($this->imgLst[$i]))
			{
				$buff=$buff.$this->modGal->gen($this->imgLst[$i]);
				if(isset($this->imgSel))
				{
					$this->discImg($i);
				}
			}
		}
		if($this->genVisor)
		{
			$buff=$buff.$this->visor();
		}
		return $buff;
	}
	function visorMod($modHTML)
	{
		$this->modVisor=$modHTML;
	}
	//Devuelve el código HTML para mostrar la imagen selecionada.
	function visor()
	{
		if(func_num_args())
		{
			$this->imgSel=$func_get_args()[0];
		}
		$this->genVisor=0;

		return $this->modVisor->gen($this->imgLst[$this->imgSel]);
	}
	//Desplaza la imagen seleccionada para el visor $inc veces.
	function incImgN($inc)
	{
		$num=$this->imgSel+$inc;
		return $this->selImgN($num);
	}
	//Setea la imagen que despliega el visor impidiendo errores con
	//números fuera de rango.
	function selImgN($num)
	{
		$max=count($this->imgLst);
		
		$this->imgSel=abs($num-intval($num/$max)*$max);
		if($num<0)
		{
			$this->imgSel=$max-$this->imgSel;
		}
		return $this->imgSel;
	}
	//Discrimina una imagen segun el valor de una de sus propiedades.
	function discImg($nImg)
	{
		$prop=$this->disc;
		if($this->imgLst[$nImg]->$prop==$this->discVal)
		{
			$this->imgSel=$nImg;
		}
	}
	//Convierte una consulta SQL en objetos Img.
	function getSQL($consulta)
	{
		$args=func_get_args();

		if(isset($args[1]))
		{
			$this->con=$args[1];
		}

		$asocLst=$this->con->query($consulta);
		$asocLst=$asocLst->fetch_all(MYSQLI_ASSOC);	//Respuesta SQL como array asociativo.

		$iMax=count($asocLst);

		for($i=0;$i<$iMax;$i++)
		{
			$this->imgLst[$i]=new Img($this->con,$asocLst[$i]);
		}
	}
}
?>