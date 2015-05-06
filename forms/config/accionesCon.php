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
		],
		[
			'variable_post.php',
			'secID'
		]
	];


	if($_POST['Tipo']==='con')
	{
		$lMax=count($labels);

		$labels[$lMax]=
		[
			'selector_lenguaje.php',
			'Lenguaje'
		];

		$labels[$lMax+1]=
		[
			'editor.php',
			'Contenido'
		];

		$conInc=
		[
			'//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js',
			'http://cdn.wysibb.com/js/jquery.wysibb.min.js',
			'http://cdn.wysibb.com/css/default/wbbtheme.css',
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
		$labels[count($labels)]=
		[
			'selector_modulo.php',
			'Archivo'
		];
	}
?>