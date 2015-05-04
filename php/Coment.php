<?php
require_once 'SQL_Obj.php';

class Coment extends SQL_Obj
{

	function __construct($con)
	{
		$nArgs=func_num_args();
		
		parent::__construct
		(
			$con,
			'Comentarios',
			[
				'Contenido',
				'Raiz',
				'Padre',
				'Baneado',
				'Nombre'
			]
		);

		$this->Nombre='Anónimo';

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
}

function incToStr($ruta , $esq)
{
	$res='';

	ob_start();

	include($ruta);

	$res=ob_get_contents();

	ob_end_clean();

	return $res;
}
function genComLst($main , $mLen , $dep , $NombreDest=NULL)
{
	for($i=0;$i<$mLen;$i++)
	{
		$nodo=& $dep[$main[$i]];

		$esq=$nodo[0];
		$hijos=$nodo[1];

		$esq['NombreDest']=$NombreDest;

		include ('../esq/coment.php');

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
		'	SELECT Contenido.Contenido as ValorCont,Contenido.Fecha,Contenido.Lenguaje, Comentarios.*
			FROM Contenido
			JOIN Comentarios
			ON Comentarios.Contenido = Contenido.ID
			WHERE Comentarios.Raiz ='.$ContID.
		'	ORDER BY Fecha asc'
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
		$padreID=$com['Padre'];
		$conID=$com['Contenido'];

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