<?php
	if(!empty($_SESSION['adminID']))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMenuOpc.php';
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMMenu.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMMenuOpc.php';

	global $con;
	if($_SESSION['lab']!==false)
	{
		$labName=getLabName();
	}
	else
	{
		$labName='NoLab';
	}

	$menu=new DOMMenu();

	$condVisible='';
	if(!isset($_SESSION['adminID']))
	{
		$condVisible='AND Visible=1';
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

	$opciones=getPriorizados
	(
		fetch_all
		(
			$con->query
			(
				'	SELECT Menu.* FROM Menu
					LEFT OUTER JOIN TagsTarget
					ON TagsTarget.GrupoID=Menu.TagsGrpID
					LEFT OUTER JOIN Laboratorios
					ON Laboratorios.ID='.$_SESSION['lab'].'
					WHERE TagsTarget.TagID=Laboratorios.TagID
				'.$condVisible
			),
			MYSQLI_ASSOC
		)
	);

	$s=0;
	while(isset($opciones[$s]))
	{
		$opcion=$opciones[$s];

		$opc=new DOMMenuOpc
		(
			htmlentities
			(
				getTraduccion
				(
					$opcion['ContenidoID'],
					$_SESSION['lang']
				)
			)
		);

		$opc->setUrl($opcion['Url']);

		if(isset($opcion['SeccionID']))
		{
			$opc->setSectionName($opcion['SeccionID']);
		}

		if(!empty($opcion['Atajo']))
		{
			$opc->setShortcutChar($opcion['Atajo']);
		}

		if(!empty($_SESSION['adminID']))
		{
			$opc->appendChild
			(
				new FormCliMenuOpc
				(
					$opcion['ContenidoID'],
					$s,
					$opcion['Visible']
				)
			);
		}
		$menu->addOption($opc);
/*
		$clase='';
		if
		(
			!empty($formMenuRecv->afectados)	&&
			in_array($opcion['ContenidoID'] , $formMenuRecv->afectados)
		)
		{
			$clase='class="target"';
		}
*/
		++$s;
	}

	if(isset($_SESSION['adminID']))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecAddBase.php';

		$formCliMenuAdd=new FormCliSecAddBase('accionesMenu' , 'opc' , gettext('Nueva Opción'));
		$formCliMenuAdd->classList->add('accionesMenu');
		
		$menu->appendChild($formCliMenuAdd);
	}

	$logo=new DOMTag('div');
	$logo->classList->add('hidden-xs');

	$link=new DOMLink();

	$h2=new DOMTag('h2');

	$img=new DOMTag('img');

	$menu->appendChild
	(
		$logo->appendChild
		(
			$h2->appendChild
			(
				$link->setUrl
				(
					'#header'
				)->setAttribute
				(
					'accesskey' ,
					'i'
				)->appendChild
				(
					$img->setAttribute
					(
						'width',
						'80'
					)->setAttribute
					(
						'width',
						'80'
					)->setAttribute
					(
						'src',
						'/img/logos/'.$_SESSION['lab'].'.png'
					)->setAttribute
					(
						'alt',
						sprintf(gettext('Logo de %s') , $labName)
					)
				)->appendChild
				(
					new DOMTag('span' , $labName)
				)
			)
		)
	);

	echo $menu->getHTML();
?>