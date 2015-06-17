<?php
	if(isset($_POST['conID']))
	{
		$this->cantidad=count($_POST['conID']);
	}
	$this->includes=['../forms/forms.css'];

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

	$lleno=fetch_all
	(
		$con->query
		(
			'	SELECT ContenidoID
				FROM Menu
				WHERE ID!='.$_SESSION['conID'].'
				ORDER BY Prioridad DESC
			'
		),
		MYSQLI_NUM
	);
	$iMax=count($lleno);
	for($i=0;$i<$iMax;$i++)
	{
		$lleno[$i][0]=getTraduccion($lleno[$i][0] , $_SESSION['lang']);
	}
	$_POST['lleno']=$lleno;

	$this->labels=
	[
		[
			'input_text.php',
			'Titulo'
		],
		[
			'input_text.php',
			'Url'
		],
		[
			'selector_orden.php',
			'Lugar'
		],
		[
			'selector_si_no.php',
			'Visible'
		]
	];
?>