<?php
class Coment extends SQLObj
{
	public $contenidoHTML='';
	public $autoContenido=1;	//Si se quiere extraer o insertar automáticamente el contenido.

	function __construct($con)
	{
		$nArgs=func_num_args();
		
		parent::__construct
		(
			$con,
			'Comentarios',
			[
				'GrupoID',
				'IP',
				'Usuario',
				'Contenido',
				'Baneado'
			]
		);
		
		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}

	//Busca el contenido correspondiente al comentario y lo guarda en contenidoHTML.
	function contenido()
	{
		if(!$this->autoContenido)
		{
			return 0;
		}
		$this->contenidoHTML=$con->query('select Contenido from Contenidos where ID='.$this->Contenido);

		return $this->contenidoHTML;
	}
}
?>