<?php

	include $_SERVER['DOCUMENT_ROOT'] . '/php/DOMCal.php';
	$cal=new DOMCal();

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
	start_session_if_not();

	$contenedor=new DOMTag('div');
	$contenedor->classList->add('calendario');

	if(!empty($_SESSION['adminID']))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliCal.php';
		
		$formCal=new FormCliCal();
		echo $formCal->getHTML();
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/opciones.php';
	
	$vista=getValFromNombreID('vista' , $this->opcGrpID , $this->opcSetsID);
	if(is_array($vista) && $vista[0]!=='true')
	{
		$vista=false;
	}
	else
	{
		$vista=true;
	}

	$consulta=
	'	SELECT Eventos.* FROM `Eventos`
		LEFT OUTER JOIN TagsTarget
		ON TagsTarget.GrupoID=Eventos.TagsGrpID
		LEFT OUTER JOIN Laboratorios
		ON Laboratorios.ID='.$_SESSION['lab'].'
		WHERE TagsTarget.TagID=Laboratorios.TagID
	';

	if($vista)
	{
		$mes=intVal(getdate()['mon']);

		$mesAct=new DateTime();
		$mesAct->setDate
		(
			$cal->fecha->format('Y'),
			$cal->fecha->format('m'),
			1
		);

		$mesSig=new DateTime();
		$mesSig->setTimestamp($mesAct->getTimestamp());
		$mesSig->add(new DateInterval('P1M'));

		$consulta=$consulta.
		'	AND Tiempo
			BETWEEN "'.$mesAct->format('Y-m-d 00:00:00').'"
			AND 	"'.$mesSig->format('Y-m-d 00:00:00').'"
		';
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	global $con;

	//echo '<pre>Consulta eventos:';print_r($consulta.' ORDER BY Prioridad, Tiempo ASC');echo '</pre>';

	$eventos=fetch_all
	(
		$con->query
		(
			$consulta.
			'	ORDER BY Tiempo,Prioridad ASC	'
		),
		MYSQLI_ASSOC
	);

	$cantEventos=count($eventos);


	$desc=new DOMTag('div');
	

	$desc->classList->add('desc');
	$desc->col=['xs'=>12 , 'sm'=>5 , 'md'=>5 , 'lg'=>5];


	if(isset($eventos[0]))						//Si hay eventos los muestro.
	{
		$descUl=new DOMTag('ul');
		$offH2=new DOMTag('h2' , gettext('Lista de eventos'));
		
		$desc->appendChild
		(
			$offH2
		)->appendChild
		(
			$descUl
		);
		

		$i=0;
		while(isset($eventos[$i]))
		{
			$evtAct=$eventos[$i];

			$descripcion=htmlentities
			(
				getTraduccion
				(
					$evtAct['DescripcionID'],
					$_SESSION['lang']
				)
			);
			$nombre=htmlentities
			(
				getTraduccion
				(
					$evtAct['NombreID'],
					$_SESSION['lang']
				)
			);

			$fecha=DateTime::createFromFormat('Y-m-d H:i:s' , $evtAct['Tiempo']);

			//Simulación de eventos.
			$cal->addEvento
			(
				$fecha,
				$nombre,
				$descripcion
			);

			$fechaMin=$fecha->format('i');
			if(strlen($fechaMin)<2)
			{
				$fechaMin='0'.$fechaMin;
			}

			$li=new DOMTag('li');
			$p=new DOMTag('p' , $descripcion);
			$h3=new DOMTag('h3' , $nombre);

			$pFecha=new DOMTag
			(
				'p',
				sprintf
				(
					/*
						Ej: Lunes 5 de Febrero a las 5:00
					*/
					gettext('%1$s %2$s de %3$s a las %4$s:%5$s'),
					$cal->dias[$fecha->format('w')],
					$fecha->format('d'),
					$cal->meses[$fecha->format('m')-1],
					$fecha->format('H'),
					$fechaMin
				)
			);

			$pFecha->classList->add('fecha');

			if(isset($_SESSION['adminID']))
			{
				$pFecha->appendChild
				(
					$formCal->buildActionCheckBox($evtAct['DescripcionID'])
				);
			}

			$descUl->appendChild
			(
				//Agregar target.
				$li->appendChild
				(
					$pFecha
				)->appendChild
				(
					$h3
				)->appendChild
				(
					$p
				)
			);

			++$i;
		}
	}
	else
	{
		$h3=new DOMTag('h3' , gettext('Ningún evento este mes.'));
		
		$desc->appendChild($h3);
	}

	

	$calCont=new DOMTag('div');

	if(isset($mes))
	{
		$calCont->col=['xs'=>12 , 'sm'=>7 , 'md'=>7 , 'lg'=>7];
	}
	else
	{
		$calCont->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
	}

	if(isset($mes))
	{
		$calCont->appendChild
		(
			$cal->buildTableMes($mes)
		);
	}
	else
	{
		for($m=1;$m<13;++$m)
		{
			$divA=new DOMTag('div');
			$divA->col=['xs'=>12 , 'sm'=>6 , 'md'=>4 , 'lg'=>4];

			$calCont->appendChild
			(
				$divA->appendChild
				(
					$cal->buildTableMes($m)
				)
			);

			if($m%3===0)
			{
				$divB=new DOMTag('div');
				$divB->classList->add('clearfix')->add('visible-md')->add('visible-lg');

				$calCont->appendChild($divB);
			}
			if($m%2===0)
			{
				$divC=new DOMTag('div');
				$divC->classList->add('clearfix')->add('visible-sm');

				$calCont->appendChild($divC);
			}
		}
	}

	class DOMCalRefBase extends DOMTag
	{
		function __construct($offText , $text , $class)
		{
			parent::__construct('div');

			$this->col=['xs'=>12 , 'sm'=>6 , 'md'=>6 , 'lg'=>6];

			$div=new DOMTag('div');

			$spanA=new DOMTag('span' , $text);
			$spanB=new DOMTag('span');
			$spanOff=new DOMTag('span' , $offText);


			$spanB->classList->add($class);;
			$spanOff->classList->add('offscreen');
			$div->classList->add('calRef');

			//Revisar
			//$this->classList->add('hidden-screader');

			$this->appendChild
			(
				$div->appendChild
				(
					$spanA
				)->appendChild
				(
					$spanB->appendChild
					(
						$spanOff
					)
				)
			);
		}
	}

	$refsCont=new DOMTag('div');
	$offh2=new DOMTag('h2' , gettext('Referencias del calendario'));

	$calCont->appendChild
	(
		$refsCont->appendChild
		(
			$offh2
		)->appendChild
		(
			new DOMCalRefBase
			(
				gettext(' representado con color celeste'),
				gettext('Evento'),
				'evento'
			)
		)->appendChild
		(
			new DOMCalRefBase
			(
				gettext(' representado con color azul'),
				gettext('Dia Actual'),
				'presente'
			)
		)
	);



	$clearFix=new DOMTag('div');
	$clearFix->classList->add('clearfix')->add('visible-xs');

	$contenedor->appendChild
	(
		new DOMTag
		(
			'h2',
			gettext('Calendario de eventos')
		)
	)->appendChild
	(
		$calCont
	)->appendChild
	(
		$clearFix
	)->appendChild
	(
		$desc	
	);

	echo $contenedor->getHTML();
?>