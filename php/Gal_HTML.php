<?php
require_once	'Obj_Gen_HTML.php';
include_once	'conexion.php';
if(isset($_SESSION['vGen']))
{
	include_once 'Gal_HTML_Visor.php';
}
//Genera el código HTML de la galería según los parametros dados.
//$img puede ser el texto de una consulta SQL
//o una lista de objetos de tipo Img.
class Gal_HTML
{
	private	$con;
	private	$modGal;
	public	$visor;

	public	$imgLst=[];
	
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
			$this->imgLst=$img;	//Si era una lista de objetos Img, la guardo.
		}

		if(isset($args[$nArgs+1]))
		{
			$this->modGal=$args[$nArgs+1];
		}
		if(isset($args[$nArgs+2]))
		{
			$this->creaVisor($args[$nArgs+2]);
		}
	}
	function creaVisor($modHTML)
	{
		$this->visor=new Gal_HTML_Visor($this,$modHTML);
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
				if(isset($this->visor))
				{
					$this->visor->discImg($i);
				}
			}
		}

		
		if(isset($this->visor))
		{
			$buff=$buff.$this->visor->gen();
		}

		return $buff;
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