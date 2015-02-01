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

		/*
		titulo.hijo
		(
			{
				tag:'a',
				innerHTML:'X',
				forma:
				{
					setAttribute:
					[
						['id','cerrar'],
						['href','inicio_sesion.php?cSesion']
					]
				}
			}
		)
*/

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
	
	tipos={}
	tipos.raiz=function(nHijo)
	{
		window.console.log('Raiz');window.console.log(arguments)

		window.panel=new Diag();
		window.panelCaja=new Caja
		(
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
		);

		panel.nCaja(panelCaja);

		document.body.appendChild(panelCaja.doc);
	}
	tipos.Tit=function(val , n)
	{
		window.console.log('Tit');window.console.log(arguments)

		window.titulo=panelCaja.hijo
		(
			{
				nom:'titulo',
				tag:'h1',
				forma:
				{
					innerHTML:val,
					style:
					[
						['width','100%'],
						['textAlign','center'],
						['position','relative']
					]
				}

			}
		)
		window.barraPes=panelCaja.hijo
		(
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
		);

		panel.nCajas(titulo , barraPes);
	}
	tipos.Pes=function(val , n)
	{
		window.console.log('Pes');window.console.log(arguments)

		panel.nCajas
			(
				barraPes.hijo
				(
					{
						nom:'p'+n,
						tag:'div',
						forma:
						{
							setAttribute:['class','pestana'],
							style:
							[
								['width',100/4+'%']
							],
							innerHTML:val,
							addEventListener:['click',function(){panel.selV('panel','vistaP'+nHijo.bind(this)())}]
						}
					}
				),
				new Caja
				(
					{
						nom:'vistaP'+n,
						tag:'div',
						forma:
						{
							setAttribute:['class','vista'],
							innerHTML:'vistaP'+n
						}
					}
				)
			);
	}

	function XMLTags(nodo)
	{
		for(var i=0;i<nodo.childNodes.length;i++)
		{
			var nodoAct=nodo.childNodes[i];

			if(nodoAct.childNodes.length)
			{
				if(nodoAct.childNodes[0].nodeName=='#text')
				{
					tipos[nodoAct.nodeName](nodoAct.childNodes[0].nodeValue , i);
					continue;
				}

				tipos[nodoAct.nodeName](i);

				XMLTags(nodo.childNodes[i]);
			}

		}
	}
	function XMLToMenu()
	{
		if(this.readyState==4 && this.status==200)
		{
			var response=this.responseXML.childNodes[0];

			XMLTags(response);

			panel.selV('panel','vistaP1');
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