<?php
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT );
//Si todavía no se inicio sesion, se inicia.

//error_reporting(E_ALL & ~E_DEPRECATED  & ~E_STRICT);

include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
reload_session( 'lang' , 'adminID' , 'lab' , 'FONT_SIZE' );

include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTMLUIndex.php';

$html=new DOMHTMLUIndex();

if($_SESSION['lab']!==false)
{
	if(isset($_GET['vRecID']))
	{
		$noLimit=$_GET['vRecID'];
		$condicion=' Secciones.ID='.$noLimit;

		$html->menu->setAbsoluteUrls( true );
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
				'	SELECT Secciones.ID,Secciones.Visible,Secciones.TituloID, Secciones.PrioridadesGrpID, Secciones.AtajoID
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

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';
	$html->appendChild
	(
		( new DOMLink() )
		->setName( 'Saltar al pie' )
		->setUrl( '#footer' )
		->setAccessKey( 'P' )
		->setAttribute( 'tabindex' , 3 )
		->setAttribute( 'id' , 'skip-to-footer' )
		->setCol( [ 'xs' => 12 , 'sm' => 10 , 'md' => 10 , 'lg' => 10 ] )
	);

	$s=0;
	while(isset($secciones[$s]))
	{
		$seccionAct=$secciones[$s];

		$section=new DOMSeccion();

		if( isset( $_SESSION['adminID'] ) )
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliColSec.php';

			$section->appendForm
			(
				new FormCliColSec( $seccionAct['ID'] , $s , $seccionAct['Visible'] )
			);
		}

		//El ID de la sección debe estar codificado de la misma forma que en el ancla de la opción del menú.
		$section->setHTMLID
		(
			$htmlid=urlencode
			(
				getTraduccion
				(
					$seccionAct['TituloID'],
					$_SESSION['lang']
				)
			)
		);

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

		if( $s === 0 )
		{
			$html->appendChild
			(
				( new DOMLink() )
				->setName( 'Saltar al contenido' )
				->setUrl( '#'.$htmlid )
				->setAccessKey( 'O' )
				->setAttribute( 'tabindex' , 2 )
				->setAttribute( 'id' , 'skip-to-content' )
				->setCol( [ 'xs' => 12 , 'sm' => 10 , 'md' => 10 , 'lg' => 10 ] )
			);
		}

		if( $seccionAct['AtajoID'] !== NULL )
		{
			$urlStr='#'.$seccionAct['TituloID'];

			/*:::Por aquí intentando resolver los atajos "anónimos":::*/
/*
			$html->body->appendChild
			(
				$link=new DOMLink()
			);
*/
			if(isset($_GET['vRecID']))
			{
				//Revisar . Código en común con VisorImagenes, DOMMenuOpc, Modulo_Novedades , Modulo_Imagenes
				
				$urlStr=
				'/'								.
				substr( getenv('LANG'), 0 , 2 )	.
				'/espacios/'					.
				getLabName()					.
				'/'								.
				$urlStr;
			}
/*
			$link
			->setName( $seccionAct['TituloID'] )
			->setUrl( $urlStr )
			->setAccessKey( $seccionAct['AtajoID'] );
*/
		}

		//Revisar.A futuro seleccionar Seccion.Visible y discriminarlo SOLO si
		//existe o no adminID.

		$includes=getPriorizados
		(
			fetch_all
			(
				$con->query
				(
					$jj='	SELECT Secciones.ID , Secciones.Visible ,Secciones.PrioridadesGrpID, Secciones.TituloID, Modulos.Archivo, Modulos.OpcGrpID, Modulos.OpcSetsGrpID, Secciones.ContenidoID
						FROM Secciones
						left outer JOIN Modulos
						ON Modulos.ID = Secciones.ModuloID
						LEFT OUTER JOIN TagsTarget
						ON TagsTarget.GrupoID=Secciones.TagsGrpID
						LEFT OUTER JOIN Laboratorios
						ON Laboratorios.ID='.$_SESSION['lab'].'
						WHERE Secciones.PadreID='.$seccionAct['ID'].'
						AND TagsTarget.TagID=Laboratorios.TagID
					'.$condVisible
				),
				MYSQLI_ASSOC
			)
		);

		$f=0;
		while( isset( $includes[ $f ] ) )
		{
			$includeAct=$includes[$f];

			if( $includeAct['ContenidoID'] !== NULL )
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

				$f_name='/css/generated/'.$includeAct['ContenidoID'].'.css';
				if( file_exists( $_SERVER['DOCUMENT_ROOT'] . $f_name ) )
				{
					$html->head_include( $f_name );
				}

				$include->load
				(
					$includeAct['ContenidoID']
				);
			}
			if( $includeAct['Archivo'] !== NULL )
			{
				global $con;

				$include=new DOMInclude();

				if( isset($_SESSION['adminID']) )
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliInc.php';

					$include->appendForm
					(
						new FormCliInc( $includeAct['ID'] , $f , $includeAct['Visible'] )
					);
				}

				if($seccionAct['ID']==$noLimit)
				{
					$include->setLimited(false);
				}
				else
				{
					$include->setLimited(true);
				}

				$include
				->setSectionID($seccionAct['ID'])
				->setModuloID($includeAct['ID'])
				->setOpcGrpID($includeAct['OpcGrpID'])
				->setOpcSetsID($includeAct['OpcSetsGrpID'])
				//->load('Modulo_Novedades');
				->load($includeAct['Archivo'])
				->calcLimit();
			}

			$section->appendChild
			(
				$include->setHTMLID
				(
					$includeAct['TituloID']
				)
			);
			

			++$f;
		}

		$html->main->appendChild($section);

		++$s;
	}

	if( isset( $_SESSION['adminID'] ) )
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecAddBase.php';

		$html->main->appendChild
		(
			new FormCliSecAddBase
			(
				'accionesSec' ,
				gettext('Nueva Sección')
			)
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