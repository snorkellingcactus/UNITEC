<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(isset($_SESSION['adminID']))
{
	if(isset($_POST['cantidad']))
	{
		$_SESSION['cantidad']=$_POST['cantidad'];
	}
	else
	{
		$_SESSION['cantidad']=1;
	}
	//echo '<h2><font color="white">'.$fId.'</font></h2>';
	if
	(
		isset($_POST['nuevas'])	&&
		isset($_POST['form'])
	)
	{
		switch($_POST['form'])
		{
			case 'accionesGal':
				$includes=['../forms/forms.css'];
				$ancla='#gal';
				$action='../index.php';
				$for='nImg';
				$labels=
				[
					[
						'text',
						'Titulo'
					],
					[
						'text',
						'Url'
					],
					[
						'text',
						'Alt'
					],
					[
						'langs',
						'Lenguaje'
					],
					[
						'text',
						'Comentario'
					]
				];
			break;
			case 'accionesNov':
				$includes=
				[
					'../forms/forms.css',
					'//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js',
					'http://cdn.wysibb.com/js/jquery.wysibb.min.js',
					'http://cdn.wysibb.com/css/default/wbbtheme.css',
					'../js/wysibbInc.js'
				];
				$ancla='#nov';
				$action='../index.php';
				$for='nNov';
				$labels=
				[
					[
						'text',
						'Titulo'
					],
					[
						'editor',
						'Descripcion'
					],
					[
						'imgs',
						'Imagen'
					]
				];
			break;
			case 'accionesCal':
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
						'date',
						'Fecha'
					],
					[
						'text',
						'Titulo'
					],
					[
						'text',
						'Descripcion'
					],
					[
						'langs',
						'Lenguaje'
					]
				];
			break;
			case 'accionesSec':
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
						'text',
						'Identificador'
					],
					[
						'orden',
						'Lugar'
					],
					[
						'SiNo',
						'Visible'
					]
				];
			break;
			case 'accionesCon':
				$includes=
				[
					'../forms/forms.css',
					'//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js',
					'http://cdn.wysibb.com/js/jquery.wysibb.min.js',
					'http://cdn.wysibb.com/css/default/wbbtheme.css',
					'../js/wysibbInc.js'
				];
				$ancla='#nCon';
				$action='../index.php';
				$for='nCon';
				$labels=
				[
					[
						'text',
						'Identificador'
					],
					[
						'orden',
						'Lugar'
					],
					[
						'SiNo',
						'Visible'
					],
					[
						'post',
						'secID'
					]
				];


				if($_POST['Tipo']==='con')
				{
					$lMax=count($labels);

					$labels[$lMax]=
					[
						'langs',
						'Lenguaje'
					];

					$labels[$lMax+1]=
					[
						'editor',
						'Contenido'
					];
				}
				else
				{
					$labels[count($labels)]=
					[
						'text',
						'Archivo'
					];
				}
			break;
		}
		include ('../forms/nuevo.php');
	}
}
?>