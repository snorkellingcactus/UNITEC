<?php
	$this->includes=
	[
		 $_SERVER['DOCUMENT_ROOT'] . '//forms/forms.css'
	];
	$this->ancla='#nSec';
	$this->labels=
	[
		[
			'selector_orden.php',
			'Lugar'
		],
		[
			'selector_si_no.php',
			'Visible'
		]
		
	];//para todos

	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';

	$lMax=count($this->labels);

	if($_POST['Tipo']==='sec')
	{
		$this->labels[$lMax]=
		[
			'input_text.php',
			'Titulo'
		];
		$this->labels[$lMax+1]=
		[
			'selector_si_no.php',
			'Agregar al menu'
		];
		$this->labels[$lMax+2]=
		[
			'input_text.php',
			'Atajo'
		];

		$padreIDStr='IS NULL';
	}
	else
	{
		$this->labels[$lMax]=
		[
			'variable_post.php',
			'conID'
		];

		if($_SESSION['accion']==='nuevo')
		{
			$padreID=$_POST['conID'];
		}
		else
		{
			$padreID=fetch_all
			(
				$con->query
				(
					'	SELECT PadreID 
						FROM Secciones
						WHERE ID='.$_POST['conID']
				),
				MYSQLI_NUM
			)[0][0];
		}

		$padreIDStr='='.$padreID;
	}

	if($_POST['Tipo']==='con')
	{
		$this->labels[$lMax+1]=
		[
			'editor.php',
			'Contenido'
		];
	}
	if($_POST['Tipo']==='inc')
	{
		//Actualizar, con lo de los módulos se convierte en un select.
		$this->labels[$lMax+1]=
		[
			'selector_modulo.php',
			'Archivo'
		];
	}

	if($_SESSION['accion']==='edita')
	{
		$padreIDStr.=' AND ID!='.$_POST['conID'];
	}
	$_POST['lleno']=fetch_all
	(
		$con->query
		(
			'	SELECT HTMLID 
				FROM Secciones
				WHERE PadreID '.$padreIDStr.'
				ORDER BY Prioridad ASC
			'
		),
		MYSQLI_NUM
	);
?>