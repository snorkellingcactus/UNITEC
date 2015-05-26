<?php
	$includes=
	[
		'../forms/forms.css'
	];
	$ancla='#nCon';
	$action='../index.php';
	$for='nCon';
	$labels=
	[
		[
			'selector_orden.php',
			'Lugar'
		],
		[
			'selector_si_no.php',
			'Visible'
		]
	];

	$lMax=count($labels);

	if($_POST['Tipo']==='con')
	{
		$labels[$lMax]=
		[
			'editor.php',
			'Contenido'
		];

		$conInc=
		[
			'../js/jquery.min.js',
			'../js/jquery.wysibb.min.js',
			'../js/wbbtheme.css',
			'../js/wysibbInc.js'
		];

		$pLen=count($conInc);
		$iLen=count($includes);
		$pMax=$iLen+$pLen;
		for($p=$iLen;$p<$pMax;$p++)
		{
			$includes[$p]=$conInc[$p-$iLen];
		}
	}
	else
	{
		//Actualizar, con lo de los módulos se convierte en un select.
		$labels[$lMax]=
		[
			'selector_modulo.php',
			'Archivo'
		];
	}

	$labels[$lMax+1]=
	[
		'variable_post.php',
		'conID'
	];
?>