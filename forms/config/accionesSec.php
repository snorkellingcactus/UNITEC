<?php
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	echo '<pre>';
	print_r($_SESSION);
	echo '</pre>';
	$includes=
	[
		'../forms/forms.css'
	];
	$ancla='#nSec';
	$action='../index.php';
	$for='nSec';
	$labels=
	[
		[
			'selector_orden.php',
			'Lugar'
		],
		[
			'selector_si_no.php',
			'Visible'
		],
		[
			'input_text.php',
			'Titulo'
		],
		[
			'selector_si_no.php',
			'Agregar al menu'
		]
	];
?>