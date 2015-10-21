<?php
class Cal_Cfg
{
	public $fecha;
	public $eventos;
				//Variables verificadas por eventosEnFecha.
				//	Horas	,	Minutos	,	Mes	,	Dia	,	Año.
	public $verif;
	public $tipo;
	public $dias;
	public $meses;

	function __construct()
	{
		$this->verif=	[	0	,	0	,	1	,	0	,	1	];
		$this->tipo	=	CAL_GREGORIAN;
		$this->dias	=
		[
			gettext('Domingo'),
			gettext('Lunes'),
			gettext('Martes'),
			gettext('Miércoles'),
			gettext('Jueves'),
			gettext('Viernes'),
			gettext('Sabado')
		];
		$this->meses=
		[
			gettext('Enero'),gettext('Febrero'),gettext('Marzo'),gettext('Abril'),
			gettext('Mayo'),gettext('Junio'),gettext('Julio'),gettext('Agosto'),
			gettext('Septiembre'),gettext('Octubre'),gettext('Noviembre'),gettext('Diciembre')
		];

		$this->fecha=getdate();
		

		$args=func_get_args();			//Array con argumentos.
		//El primer argumento es la fecha en que se basa el calendario.
		if(count($args))
		{
			$this->fecha=$args[0];
		}
	}
	function adEvento()
	{
		$args=func_get_args();
		$last=count($this->eventos);
		$this->eventos[$last]=[$args[0] , $args[1] , $args[2]];
	}
	function verifEvt($evt , $fecha)
	{
		$fechaEvt=$this->eventos[$evt][0];
		$verif=$this->verif;

		if
		(
			((!$verif[0])||($fechaEvt["hours"]		==	$fecha['hours']		))&
			((!$verif[1])||($fechaEvt["minutes"]	==	$fecha['minutes']	))&
			((!$verif[2])||($fechaEvt["mon"]		==	$fecha['mon']		))&
			((!$verif[3])||($fechaEvt["mday"]		==	$fecha['mday']		))&
			((!$verif[4])||($fechaEvt["year"]		==	$fecha['year']		))
		)
		{
			return 1;
		}
		return 0;
	}
	//Devuelve el número del primer evento que coincida con la fecha, empezando a analizar desde el n de evento pasado por argumento.
	//Si no hay coincidencias devuelve -1;
	function eventoEnFecha($fecha)
	{
		$iMax=count($this->eventos);
		$args=func_get_args();
		$desde=0;

		if(isset($args[1]))
		{
			$desde=$args[1];
		}

		while($desde<$iMax)
		{
			if($this->verifEvt($desde,$fecha))
			{
				return $desde;
			}

		++$desde;
		}
		return -1;
	}
	function eventosEnFecha($fecha)
	{
		$eventos=[];
		$eventosInd=0;
		$cuenta=0;
		$iMax=count($this->eventos);
		while($cuenta<$iMax)
		{
			$cuenta=$this->eventoEnFecha($fecha , $cuenta);
			if($cuenta!=-1)
			{
				$eventos[$eventosInd]=$this->eventos[$cuenta];

				++$eventosInd;
				++$cuenta;
			}
			else
			{
				break;
			}
		}
		return $eventos;
	}
}
?>