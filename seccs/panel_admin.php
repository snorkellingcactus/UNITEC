
<!DOCTYPE html >
<?php
//Solo si se está en modo administrador.
if(isset($_SESSION['adminID']))
{
	include_once 'php/conexion.php';
	include_once 'php/SQL_DOM.php';

	$usuario=$con->query('select * from Usuarios where ID='.$_SESSION['adminID']);
	$usuario=fetch_all($usuario , MYSQLI_ASSOC)[0];
?>

<div class="panelAdmin">
	<script type="text/javascript" src="js/Caja.js"></script>
	<script type="text/javascript" src="js/Diag.js"></script>
	<script type="text/javascript" src="js/XMLObj.js"></script>
	<script type="text/javascript" src="js/CajaProto.js"></script>
	<script type="text/javascript" src="js/PanelAdmin.js"></script>
	<script type="text/javascript">
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


	function actPanel()
	{
		if(this.status==200 && this.readyState===4)
		{
			conf=panel.xmlObj.xmlHttp.responseXML.childNodes[0];

			var nombres=conf.getElementsByTagName('Nombre');
			var padres=conf.getElementsByTagName('Padre');

			for(var i=0;i<nombres.length;i++)
			{
				if(padres[i].childNodes[0].nodeValue!=='null')
				{
					
				}
				var nombre=nombres[i];
				var val='?';


				if(nombre.childNodes[0])
				{
					val=nombre.childNodes[0].nodeValue;
				}

				panel.proto.creaTipo('tModulosTr' ,['Nombre' , val] , 0);
			}
			//conf=XMLToDOM(panel.cfg);

			window.console.log(conf);
		}
	}
	panel=new PanelAdmin();

	panel.proto.tipos.tModulos=
	{
		hijo:
		{
			nom:'tModulos',
			tag:'table',
			forma:
			{
				setAttribute:['class','tabla1']
			},
			hijos:
			[
				{
					tag:'th',
					innerHTML:'Modulo'
				},
				{
					tag:'th',
					innerHTML:'Requiere'
				}
			]
		}
	};
	panel.proto.tipos.tModulosTr=
	{
		'tModulos':
		{
			nom:'tModulosTr',
			tag:'tr'
		},
		dist:function(caja , val , n)
		{
			var doc=caja.doc.childNodes;

			for(var i=0;i<val.length;i++)
			{
				caja.hijo
				(
					{
						tag:'td'
					}
				).doc.innerHTML=val[i];
			}
			
		}
	}

	panel.proto.creaTipo('raiz' , 0 , 0);
	panel.proto.creaTipo('Tit' , 'Panel Admin' ,0);

	panel.proto.creaTipo('Pes' , 'Modulos' , 'Mod');
	panel.proto.creaTipo('tModulos' , 'vistaPMod' , 0);

	panel.diag.caja('vistaPMod').doc.appendChild(panel.diag.caja('tModulos').doc)

	//panel.proto.creaTipo('Pes' , 'Edita Configuración' , 'Cfg');
	//panel.proto.creaTipo('cfgEdit' , 'Edita Configuración' , 0);

	panel.diag.selV('panel','vistaPMod');


	panel.getConfPath='/php/mkCon.php'
	panel.pattern='select * from Modulos where 1';
	panel.prepareXmlHttp();
	panel.xmlObj.conf({handler:actPanel});
	panel.xmlObj.envia();

	document.getElementsByTagName('main')[0].appendChild(panel.diag.caja('panel').doc);

	</script>
	<h1>Bienvenido <?php echo $usuario['Nombre'] ?></h1>
</div>

<?php
}
?>