<?php
	if(isset($_POST['Titulo']))
	{
		$cantidad=$_POST['Titulo'];
	}

	$includes=
	[
		'../forms/forms.css'
	];
	$ancla='#cal';
	$action='../index.php';
	$for='nEvt';
	$labels=
	[
		[
			'selector_fecha.php',
			'Fecha'
		],
		[
			'input_text.php',
			'Titulo'
		],
		[
			'input_text.php',
			'Descripcion'
		],
		[
			'selector_lenguaje.php',
			'Lenguaje'
		],
		[
			'selector_si_no.php',
			'Visible'
		],
		[
			'input_text.php',
			'Prioridad'
		]
	];
?>