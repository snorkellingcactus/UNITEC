<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMMenu.php';

	class DOMMenuUnitec extends DOMMenu
	{
		private $absoluteUrls;

		function __construct()
		{
			parent::__construct();
			$this->setAttribute('style' , 'visibility:hidden');

			$this->setAbsoluteUrls( false );
		}
		function setAbsoluteUrls( $absoluteUrls )
		{
			$this->absoluteUrls=$absoluteUrls;

			return $this;
		}
		function renderChilds(&$tag)
		{
			$condVisible='';
			if(!isset($_SESSION['adminID']))
			{
				$condVisible='AND Menu.Visible=1';
			}

			if($_SESSION['lab']!==false)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMMenuOpc.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
				
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
							'	SELECT Menu.*, Secciones.AtajoID, Secciones.TituloID
								FROM Menu
								LEFT OUTER JOIN TagsTarget
								ON TagsTarget.GrupoID=Menu.TagsGrpID
								LEFT OUTER JOIN Secciones
								ON Secciones.ID=Menu.SeccionID
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

					$opc->setAbsoluteUrl( $this->absoluteUrls );

					if(isset($opcion['TituloID']))
					{
						$opc->setSectionName
						(
							getTraduccion
							(
								$opcion['TituloID'],
								$_SESSION['lang']
							)
						);
					}

					$opc->setUrl
					(
						getTraduccion
						(
							$opcion['UrlID'],
							$_SESSION['lang']
						)
					);

					if( $opcion['AtajoID'] !== NULL )
					{
						$opc->setShortcutChar
						(
							getTraduccion
							(
								$opcion['AtajoID'],
								$_SESSION['lang']
							)
						);
					}

					if( isset( $_SESSION['adminID'] ) )
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

			if(isset($_SESSION['adminID']))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecAddMenu.php';
				
				$this->span->appendChild
				(
					new FormCliSecAddMenu()
				);
			}

			$logo=new DOMTag('div');
			$logo->addToAttribute('class' , 'hidden-xs');

			$link=new DOMLink();

			$link->addToAttribute('class' , 'focuseable');

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

			return parent::renderChilds($tag);
		}
	}
?>