<?php
require_once	$_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Obj_Gen_HTML.php';
include_once	$_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
if(isset($_SESSION['vGen']))
{
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Gal_HTML_Visor.php';
}
//Genera el código HTML de la galería según los parametros dados.
//$img puede ser el texto de una consulta SQL
//o una lista de objetos de tipo Img.
class Gal_HTML
{
	private	$con;
	private	$modGal;
	public	$visor;
	public	$mkFlechas=true;

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
	function creaVisor($modHTML=NULL)
	{
		$this->visor=new Gal_HTML_Visor($this,$modHTML);

		return $this->visor;
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
		$asocLst=fetch_all($asocLst , MYSQLI_ASSOC);	//Respuesta SQL como array asociativo.

		$iMax=count($asocLst);

		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		if(session_status()===PHP_SESSION_NONE)
		{
			session_start();
		}

		for($i=0;$i<$iMax;$i++)
		{
			$nImg=$asocLst[$i];

			$nImg['TituloCon']=getTraduccion($nImg['TituloID'] , $_SESSION['lang']);

			$this->imgLst[$i]=new Img($this->con, $nImg);
		}
	}
}
?>