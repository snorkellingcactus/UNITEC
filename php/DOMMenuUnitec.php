<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMMenu.php';

	class DOMMenuUnitec extends DOMMenu
	{
		function __construct()
		{
			parent::__construct();
		}

		function renderChilds(&$doc , &$tag)
		{
			$condVisible='';
			if(!isset($_SESSION['adminID']))
			{
				$condVisible='AND Visible=1';
			}

			if($_SESSION['lab']!==false)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMMenuOpc.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
				
				if(isset($_SESSION['adminID']))
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMenuOpc.php';
				}

				global $con;

				$labName=getLabName();

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

					if(isset($opcion['SeccionID']))
					{
						$opc->setSectionName($opcion['SeccionID']);
					}

					$opc->setUrl($opcion['Url']);

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
					$this->addOption($opc);

					++$s;
				}
			}
			else
			{
				$labName='NoLab';
			}

			if(isset($_SESSION['adminID']))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecAddMenu.php';
				
				$this->span->appendChild
				(
					new FormCliSecAddMenu()
				);
			}

			$logo=new DOMTag('div');
			$logo->classList->add('hidden-xs');

			$link=new DOMLink();

			$link->classList->add('focuseable');

			$h2=new DOMTag('h2');

			$img=new DOMTag('img');

			$this->span->appendChild
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

			return parent::renderChilds($doc , $tag);
		}
	}
?>