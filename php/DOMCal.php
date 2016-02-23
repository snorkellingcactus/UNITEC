<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTable.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMThead.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTbody.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTr.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTh.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTd.php';

	class DOMCal
	{
		public $fecha;
		public $eventos;
		public $verif;
		public $tipo;
		public $dias;
		public $meses;
		public $eLen;
		public $filas;

		function __construct()
		{
							//Variables verificadas por eventosEnFecha.
							//	Horas	,	Minutos	,	Mes	,	Dia	,	Año.
			$this->verif=	[	0		,	0		,	1	,	1	,	1	];
			$this->tipo	=	CAL_GREGORIAN;
			$this->dias	=
			[
				gettext('Domingo'),
				gettext('Lunes'),
				gettext('Martes'),
				gettext('Miércoles'),
				gettext('Jueves'),
				gettext('Viernes'),
				gettext('Sábado')
			];
			$this->meses=
			[
				gettext('Enero'),		gettext('Febrero'),	gettext('Marzo'),		gettext('Abril'),
				gettext('Mayo'),		gettext('Junio'),	gettext('Julio'),		gettext('Agosto'),
				gettext('Septiembre'),	gettext('Octubre'),	gettext('Noviembre'),	gettext('Diciembre')
			];

			$this->eLen=0;
			
			$args=func_get_args();
			
			if(isset($args[0]))
			{
				$this->setFecha($args[0]);
			}
			else
			{
				$this->setFecha(new DateTime('now' , new DateTimeZone('America/Argentina/Buenos_Aires')));
			}
		}

		function calcFilas($fDest)
		{
			return $this->filas=ceil
			(
				(
					cal_days_in_month
					(
						$this->tipo ,
						$fDest->format('m'),
						$fDest->format('Y')
					)	+	$fDest->format('w')
				)/7
			);
		}

		function buildTrMes($nMes)
		{
			$tr=new DOMTr();
			$th=new DOMTh();

			return $tr->appendChild
			(
				$th->setColspan(7)->setTagValue
				(
					$this->meses
					[
						abs($nMes-1)
					]
				)
			);
		}
		function buildThDia($dayName)
		{
			$thDia=new DOMTh();
				
			return $thDia->setTagValue($dayName);
		}
		function buildTrThDias()
		{
			$tr=new DOMTr();

			$i=0;
			$dias=$this->dias;
			while(isset($dias[$i]))
			{
				$tr->appendChild
				(
					$this->buildThDia
					(
						$dias[$i]
					)
				);

				++$i;
			}

			return $tr;
		}
		function buildTdDia($mesReal , $mesActual , $mesDestino , $diaReal , $diaActual , $fechaActual)
		{
			$td=new DOMTd();

			$posiblePresente=true;

			if($mesActual>$mesDestino)
			{
				$td->classList->add('dia-mes-siguiente');

				$posiblePresente=false;
			}
			if($mesActual<$mesDestino)
			{
				$td->classList->add('dia-mes-anterior');

				$posiblePresente=false;
			}

			if($mesReal===$mesDestino && $posiblePresente)
			{
				if($diaActual<$diaReal)
				{
					$td->classList->add('pasado');
				}
				if($diaActual===$diaReal)
				{
					$td->classList->add('presente');
				}
				if($diaActual>$diaReal)
				{
					$td->classList->add('futuro');
				}
			}
			
			if($posiblePresente && $this->eventoEnFecha($fechaActual)!=-1)
			{
				$td->classList->add('evento');
			}

			return $td->appendChild
			(
				new DOMTag
				(
					'p',
					$diaActual
				)
			);
		}
		function buildTrDias($fechaDest , $mesReal , $mesDest , $diaReal)
		{
			$tr=new DOMTr();

			for($j=0;$j<7;$j++)
			{
				$tr->appendChild
				(
					$this->buildTdDia
					(
						$mesReal,
						$fechaDest->format('m'),
						$mesDest,
						$diaReal,
						$fechaDest->format('d'),
						$fechaDest
					)
				);

				$fechaDest->add
				(
					new DateInterval('P1D')
				);
			}

			return $tr;
		}
		//Genera las celdas para el <thead>
		//Genera las celdas para el <tbody>.
		function buildTbody($fechaDest , $mesReal)
		{
			$tbody=new DOMTBody();

			$diaReal=$this->fecha->format('d');

			$fechaInicio=new DateTime('now' , new DateTimeZone('America/Argentina/Buenos_Aires'));
			$fechaInicio->setTimestamp($fechaDest->getTimestamp());

			$this->calcFilas($fechaInicio);

			$fechaInicio->sub
			(
				new DateInterval
				(
					'P'.$fechaInicio->format('w').'D'
				)
			);

			$mesDest=$fechaDest->format('m');

			$iMax=$this->filas;

			for($i=0;$i<$iMax;++$i)
			{
				$tbody->appendChild
				(
					$this->buildTrDias($fechaInicio , $mesReal , $mesDest , $diaReal)
				);
			}

			

			return $tbody;
		}
		function buildTableMes()
		{
			$args=func_get_args();

			if(isset($args[0]))
			{
				$nMes=$args[0];

				if(isset($args[1]))
				{
					$nAno=$args[1];
				}
				else
				{
					$nAno=$this->fecha->format('Y');
				}
			}
			else
			{
				$nMes=$this->fecha->format('m');
			}

			//Revisar. Internacionalizar. Buscar new DateTime en otros archivos y reemplazar.
			$fecha=new DateTime('now' , new DateTimeZone('America/Argentina/Buenos_Aires'));
			$fecha->setDate
			(
				$nAno,
				$nMes,
				1
			);

			$mesReal=$this->fecha->format('m');

			$table=new DOMTable();
			$thead=new DOMThead();

			$table->appendChild
			(
				$thead->appendChild
				(
					$this->buildTrMes($nMes)
				)->appendChild
				(
					$this->buildTrThDias()
				)
			)->appendChild
			(
				$this->buildTbody($fecha , $mesReal)
			);

			if($nMes>$mesReal)
			{
				$table->classList->add('mes-futuro');
			}
			if($nMes<$mesReal)
			{
				$table->classList->add('mes-pasado');
			}
			if($nMes==$mesReal)
			{
				$table->classList->add('mes-presente');
			}

			return $table;
		}
		//Genera las tablas de los números de meses pasados por argumento.
		function buildTablasMeses()
		{
			for($i=0;$i<12;$i++)
			{
				$buildTablaMes($i);
			}
		}

		function setFecha($fecha)
		{
			$this->fecha=$fecha;
		}

		function addEvento($fecha , $nombre , $descripcion)
		{
			$this->eventos[$this->eLen]=[$fecha , $nombre , $descripcion];

			++$this->eLen;
		}

		function compareDates($dateA , $dateB , $unit)
		{
			return $dateA->format($unit)===$dateB->format($unit);
		}

		function verifEvt($evt , $fecha)
		{
			$fechaEvt=$this->eventos[$evt][0];
			$verif=$this->verif;

			if
			(
				((!$verif[0])||($this->compareDates($fechaEvt , $fecha , 'H')))&
				((!$verif[1])||($this->compareDates($fechaEvt , $fecha , 'i')))&
				((!$verif[2])||($this->compareDates($fechaEvt , $fecha , 'm')))&
				((!$verif[3])||($this->compareDates($fechaEvt , $fecha , 'd')))&
				((!$verif[4])||($this->compareDates($fechaEvt , $fecha , 'Y')))
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
			$desde=0;

			$args=func_get_args();
			if(isset($args[1]))
			{
				$desde=$args[1];
			}

			$iMax=$this->eLen;
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
			$iMax=$this->eLen;
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