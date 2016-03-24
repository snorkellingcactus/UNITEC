<!DOCTYPE HTML >
<?php
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT );
//Si todavía no se inicio sesion, se inicia.

//error_reporting(E_ALL & ~E_DEPRECATED  & ~E_STRICT);

include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTMLUIndex.php';

session_start();
session_destroy();

$html=new DOMHTMLUIndex();

if($_SESSION['lab']!==false)
{
	if(isset($_GET['vRecID']))
	{
		$noLimit=$_GET['vRecID'];
		$condicion=' Secciones.ID='.$noLimit;
	}
	else
	{
		$noLimit=false;
		$condicion='Secciones.PadreID IS NULL';
	}

	$condVisible='';
	if(!isset($_SESSION['adminID']))
	{
		$condVisible='AND Visible=1';
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

	$secciones=getPriorizados
	(
		fetch_all
		(
			$con->query
			(
				'	SELECT Secciones.ID,Secciones.Visible,Secciones.HTMLID, Secciones.PrioridadesGrpID
					FROM Secciones
					LEFT OUTER JOIN TagsTarget
					ON TagsTarget.GrupoID=Secciones.TagsGrpID
					LEFT OUTER JOIN Laboratorios
					ON Laboratorios.ID='.$_SESSION['lab'].'
					WHERE '.$condicion.'
					AND TagsTarget.TagID=Laboratorios.TagID
					'.$condVisible
			),
			MYSQLI_ASSOC
		)
	);

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMContenido.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMInclude.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMSeccion.php';

	global $con;

	$s=0;
	while(isset($secciones[$s]))
	{
		$seccionAct=$secciones[$s];

		$section=new DOMSeccion();

		if(isset($_SESSION['adminID']))
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliColSec.php';

			$section->appendForm
			(
				new FormCliColSec($seccionAct['ID'] , $s , $seccionAct['Visible'])
			);
		}

		$section->setHTMLID
		(
			$seccionAct['HTMLID']
		);

		//Revisar.A futuro seleccionar Seccion.Visible y discriminarlo SOLO si
		//existe o no adminID.

		$includes=getPriorizados
		(
			fetch_all
			(
				$con->query
				(
					'	SELECT Secciones.ID , Secciones.Visible ,Secciones.PrioridadesGrpID, Secciones.HTMLID, Modulos.Archivo, Modulos.OpcGrpID, Modulos.OpcSetsGrpID, Contenidos.ID as ContenidoID
						FROM Secciones
						left outer JOIN Modulos
						ON Modulos.ID = Secciones.ModuloID
						left outer JOIN Contenidos
						ON Contenidos.ID = Secciones.ContenidoID
						LEFT OUTER JOIN TagsTarget
						ON TagsTarget.GrupoID=Secciones.TagsGrpID
						LEFT OUTER JOIN Laboratorios
						ON Laboratorios.ID='.$_SESSION['lab'].'
						WHERE Secciones.PadreID='.$seccionAct['ID'].'
						AND TagsTarget.TagID=Laboratorios.TagID
					'
				),
				MYSQLI_ASSOC
			)
		);

		$f=0;
		while(isset($includes[$f]) && $f<2)
		{
			$includeAct=$includes[$f];

			if($includeAct['ContenidoID']!==NULL)
			{
				$include=new DOMContenido();

				if(!empty($_SESSION['adminID']))
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliCon.php';

					$include->appendForm
					(
						new FormCliCon($includeAct['ID'] , $f , $includeAct['Visible'])
					);
				}
				
				$include->load
				(
					$includeAct['ContenidoID']
				);
			}
			if($includeAct['Archivo']!==NULL)
			{
				global $con;

				$include=new DOMInclude();

				if(isset($_SESSION['adminID']))
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliInc.php';

					$include->appendForm
					(
						new FormCliInc($includeAct['ID'] , $f , $includeAct['Visible'])
					);
				}

				if($seccionAct['ID']==$noLimit)
				{
					$include->setLimit(false);
				}
				else
				{
					$include->setLimit(true);
				}

				$include
				->setSectionID($seccionAct['ID'])
				->setModuloID($includeAct['ID'])
				->setOpcGrpID($includeAct['OpcGrpID'])
				->setOpcSetsID($includeAct['OpcSetsGrpID'])
				//->load('Modulo_Novedades');
				->load($includeAct['Archivo']);
			}

			$section->appendChild
			(
				$include->setHTMLID
				(
					$includeAct['HTMLID']
				)
			);
			

			++$f;
		}

		$html->main->appendChild($section);

		++$s;
	}

	if(isset($_SESSION['adminID']))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecAddBase.php';

		$html->main->appendChild
		(
			new FormCliSecAddBase('accionesSec' , 'sec' , gettext('Nueva Sección'))
		);
	}
}
else
{
	if(isset($_SESSION['adminID']))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Modulo_Organigrama.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMSeccion.php';

		$section=new DOMSeccion();

		$html->main->appendChild
		(
			$section->appendChild
			(
				new Modulo_Organigrama()
			)
		);

		//detectLab()
	}
}

echo $html->getHTML();
?>