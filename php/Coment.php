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
				'GrupoID',
				'GrupoRes',
				'Respondido',
				'Fecha',
				'IP',
				'Usuario',
				'NombreUsuario',
				'Contenido',
				'Baneado'
			]
		);

		$this->NombreUsuario='Anónimo';

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
}

include_once '../php/Inc_Esq.php';

//Genero los comentarios.
global $comentsMod;

$comentsMod=new Inc_Esq('../esq/coment.php');

function GenCom($conRes , $con)
{
	$props=[];

	if(isset($conRes['NombreUsuario']))
	{
		$props['NombreUsuario']=$conRes['NombreUsuario'];
	}
	$props['ID']=$conRes['ID'];
	$props['Fecha']=$conRes['Fecha'];

	$conRes=$con->query('select Contenido from Contenido where ID='.$conRes['Contenido']);

	$props['Contenido']=fetch_all($conRes , MYSQLI_ASSOC)[0]['Contenido'];

	$conRes=new Coment
	(
		$con,
		$props
	);

	return $conRes;
}

function GenComLst($consulta , $con)
{
	global $comentsMod;

	$comentBuff='';

	$cantidad=count($consulta);

	$args=func_get_args();

	if(!$cantidad)
	{
		$comentBuff='<p>Sin comentarios</p>';
	}
	else
	{
		for($i=0;$i<$cantidad;$i++)
		{
			$nCom=GenCom($consulta[$i] , $con);

			if(isset($args[2]))
			{
				$nCom->NombreDest=$args[2];
			}

			$nCom=$comentsMod->recorre($nCom);

			$comentBuff=$comentBuff.$nCom;

			if($consulta[$i]['Respondido']=='1')
			{

				$subCons=$con->query
				(
					'select * from Comentarios where GrupoRes='
					.$consulta[$i]['ID']
				);

				$subCons=fetch_all($subCons , MYSQLI_ASSOC);

				$nCom=GenComLst
				(
					$subCons,
					$con,
					$consulta[$i]['NombreUsuario']
				);

				$comentBuff=$comentBuff
				.'<div class="nHilo">'
				.$nCom
				.'</div>';
			}
		}
	}

	return $comentBuff;
}

function GenComGrp($GrupoID , $con)
{
	$consulta=$con->query('select * from Comentarios where GrupoID='.$GrupoID.' and GrupoRes is NULL');
	$consulta=fetch_all($consulta , MYSQLI_ASSOC);

	return GenComLst($consulta , $con);
}
?>