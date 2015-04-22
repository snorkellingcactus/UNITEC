
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
			panel.getConf.bind(panel)();


			conf=XMLToDOM(panel.cfg);

			window.console.log(conf);
		}
	}
	panel=new PanelAdmin();

	panel.proto.creaTipo('raiz' , 0 , 0);
	panel.proto.creaTipo('Tit' , 'Panel Admin' ,0);

	panel.proto.creaTipo('Pes' , 'Modulos' , 'Sec');

	//panel.proto.creaTipo('Pes' , 'Edita Configuración' , 'Cfg');
	//panel.proto.creaTipo('cfgEdit' , 'Edita Configuración' , 0);
	//panel.diag.selV('panel','vistaPCfg');
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