<?php
include_once	$_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
//Genera el código HTML de la galería según los parametros dados.
//$img puede ser el texto de una consulta SQL
//o una lista de objetos de tipo Img.
class Gal_HTML
{
	private	$modGal;
	public	$mkFlechas=true;

	public	$imgLst=[];
	
	function __construct($imgLst , $include)
	{
		$this->imgLst=$imgLst;	//Si era una lista de objetos Img, la guardo.

		$this->modGal=$include;
	}
	function gen()
	{
		$iMax=count($this->imgLst);
		
		for($i=0;$i<$iMax;$i++)
		{
			$this->modGal->data=$this->imgLst[$i];
			$this->modGal->getContent();
		}
	}
}
?>