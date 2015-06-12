<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';

class Comentario extends SQL_Obj
{

	function __construct($props=NULL , $con=NULL)
	{
		$nArgs=func_num_args();
		
		parent::__construct
		(
			'Comentarios',
			[
				'ID',
				'ContenidoID',
				'RaizID',
				'PadreID',
				'Fecha',
				'Baneado',
				'Nombre'
			],
			$con
		);

		$this->Nombre='Anónimo';

		if($props!==NULL)
		{
			$this->getAsoc($props);
		}
	}
}
function genComLst($main , $mLen , $dep , $NombreDest=NULL)
{
	for($i=0;$i<$mLen;$i++)
	{
		$nodo=& $dep[$main[$i]];

		$esq=$nodo[0];
		$hijos=$nodo[1];

		$esq['NombreDest']=$NombreDest;

		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		$esq['ValorCont']=getTraduccion($esq['ContenidoID'] , $_SESSION['lang']);

		include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/esq/coment.php';

		$hMax=count($hijos);

		if($hMax)
		{
			$nom=$esq['Nombre'];

			?>
				<div class="nHilo">
					<?php
						genComLst($hijos , $hMax , $dep , $nom);
					?>
				</div>
			<?php
		}
	}
}
function GenComGrp($ContID , $con)
{
	$consulta=$con->query
	(
		'	SELECT *
			FROM Comentarios
			WHERE Comentarios.RaizID ='.$ContID.
		'	ORDER BY Fecha ASC'
	);

	$consulta=fetch_all($consulta , MYSQLI_ASSOC);

	$cLen=count($consulta);

	if($cLen===0)
	{
		?>
			<p>Sin Comentarios</p>
		<?
	}

	$dep=[];
	$main=[];
	$mLen=0;

	$i=0;
	while($i<$cLen)
	{
		$com=$consulta[$i];
		$padreID=$com['PadreID'];
		$conID=$com['ContenidoID'];

		++$i;

		//echo '<pre>Padre : '.$padreID.' ; Contenido : '.$conID.'</pre>';
		if(!isset($dep[$conID]))
		{
			$dep[$conID]=[$com,[]];
		}
		else
		{
			$dep[$conID][0]=$com;
		}

		if($padreID==$ContID)
		{
			$main[$mLen]=$conID;
			++$mLen;
		}
		else
		{
			if(!isset($dep[$padreID]))
			{
				$dep[$padreID]=[false,[$conID]];
			}

			$depAct=& $dep[$padreID][1];

			$depAct[count($depAct)]=$conID;
		}
	}

	genComLst($main , $mLen , $dep);
}
?>