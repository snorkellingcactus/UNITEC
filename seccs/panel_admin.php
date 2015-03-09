<!DOCTYPE html >
<?php
//Solo si se está en modo administrador.
if(isset($_SESSION['adminID']))
{
	include_once 'php/conexion.php';
	include_once 'php/SQL_DOM.php';

	$sql=$con->query('select * from SQLXML where Val="panelAdmin"');
	$sql=$sql->fetch_all(MYSQLI_ASSOC)[0];

	$OpcionA=new SQL_DOM($con , $sql);
	$OpcionA->getArbolSQL();

/*
	$OpcionA=new SQL_DOM
	(
		$con , 
		[
			'Val'=>'panelAdmin',
			'Tipo'=>'Raiz',
			'hijos'=>
			[
				[
					'Tipo'=>'Tit',
					'Val'=>'Administracion',
					'hijos'=>
					[
						[
							'Val'=>'Pes 1',
							'Tipo'=>'Pes'
						],
						[
							'Val'=>'Pes 2',
							'Tipo'=>'Pes'
						],
						[
							'Val'=>'Pes 3',
							'Tipo'=>'Pes'
						],
						[
							'Val'=>'Pes 4',
							'Tipo'=>'Pes'
						]
					]
				]
			]
		]
	);

	$OpcionA->insArbolSQL();
*/
/*

	$Opcion=$OpcionA->hijos[0]->hijos[3];




	echo '<h1> Opcion ID = '.$Opcion->ID.'</h1>';

	foreach($Opcion->props as $clave=>$valor)
	{
		echo '<h1> Opcion ['.$valor.'] = '.$Opcion->$valor.'</h1>';
	}
*/

	//$OpcionA->insSQL();
	//$OpcionA->get();
	//$OpcionA->Val="pes0";

	//$OpcionA->insSQL();

	$usuario=$con->query('select * from Usuarios where ID='.$_SESSION['adminID']);
	$usuario=$usuario->fetch_all(MYSQLI_ASSOC)[0];
?>

<div class 'panelAdmin'>
	<script type="text/javascript" src="js/Caja.js"></script>
	<script type="text/javascript" src="js/Diag.js"></script>
	<script type="text/javascript" src="js/XMLObj.js"></script>
	<script type="text/javascript" src="js/Menu_XML.js"></script>
	<script type="text/javascript">
		function nHijo()
		{
			var hijos=this.parentNode.getElementsByTagName(this.tagName);
			var i=0;
			var iMax=20;
			while(hijos[i]!=this)
			{
				i++
			}

			return i+1;
		}

	document.body.appendChild
	(
		new Caja
		(
			{
				tag:'div',
				forma:
				{
					style:
					[
						['clear','both'],
						['minWidth','1px']
					]
				}
			}
		).doc
	)

	menuXML=new MenuXML();
	menuXML.diag=new Diag();
	menuXML.tipos=
	{
		'raiz':
		{
			hijo:
			{
				nom:'panel',
				tag:'div',
				forma:
				{
					style:
					[
						['width','80%'],
						['backgroundColor','white'],
						['color','black'],
						['margin','auto']
					],
					setAttribute:['id','panel']
				}
			}
		},
		'Tit':
		{
			'panel':
			[
				{
					nom:'titulo',
					tag:'h1',
					forma:
					{
						style:
						[
							['width','100%'],
							['textAlign','center'],
							['position','relative']
						]
					}
	
				},
				{
					nom:'pestanas',
					tag:'div',
					forma:
					{
						style:
						[
							['width','100%'],
							['minHeight','1em'],
							['border','1px solid gray']
						],
						setAttribute:['class','pestanas'],
					}
				}
			],
			dist:function(caja , val , n)
			{
				if(caja.nom=='titulo')
				{
					caja.doc.innerHTML=val;
				}
			}
		},
		'Pes':
		{
			'pestanas':
			{
				nom:'p',
				tag:'div',
				forma:
				{
					setAttribute:['class','pestana'],
					addEventListener:['click',function(){menuXML.diag.selV('panel','vistaP'+nHijo.bind(this)())}]
				}
			},
			'hijo':
			{
				nom:'vistaP',
				tag:'div',
				forma:
				{
					setAttribute:['class','vista'],
					innerHTML:'vistaP'
				}
			},
			dist:function(caja , val , n)
			{
				if(caja.nom=="p")
				{
					caja.doc.innerHTML=val;
				}
				if(caja.nom=='vistaP')
				{
					caja.doc.innerHTML+=n;
				}
				caja.nom+=n;
			}
		}
	}
	function XMLToMenu()
	{
		if(this.readyState==4 && this.status==200)
		{
			var response=this.responseXML.childNodes[0];

			menuXML.XMLTags(response);

			//Fix ancho pestañas.
			var pestanas=menuXML.diag.caja('pestanas').doc.getElementsByTagName('div');

			multipleCSS
			(
				{width:(100/pestanas.length)+'%'},
				pestanas
			)

			menuXML.diag.selV('panel','vistaP1');

			document.body.appendChild(menuXML.diag.caja('panel').doc);
		}
	}
	MenuReq=new XMLObj
	(
		{
			url:'http://localhost/Web/Pasant%C3%ADa/edetec/php/SQL_XML.php',
			args:{'raiz':'panelAdmin'},
			handler:XMLToMenu
		}
	)
	MenuReq.envia();
	</script>
	<h1>Bienvenido <?php echo $usuario['Nombre'] ?></h1>
</div>

<?php
}
?>