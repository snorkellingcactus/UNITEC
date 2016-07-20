<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMMenu.php';

	class DOMMenuUnitec extends DOMMenu
	{
		private $absoluteUrls;
		private $navLang;

		function __construct()
		{
			parent::__construct();

			$this->setAbsoluteUrls( false );

			//$this->addToAttribute('style' , 'visibility:hidden');
		}
		function setAbsoluteUrls( $absoluteUrls )
		{
			$this->absoluteUrls=$absoluteUrls;

			return $this;
		}
		function appendTitledElement( $title , $element )
		{
			$this->span
			->appendChild( new DOMTag( 'h1' , $title ) )
			->appendChild( $element );
		}
		function renderChilds(&$tag)
		{

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLangUnitec.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/OffText.php';

			$this->navLang=new DOMLangUnitec();

			$container=new DOMTag('span');
			$idioma=new DOMTag( 'h1' , gettext( 'Idioma ' ) );

			$this->span->appendChild
			(
				$idioma->addToAttribute( 'class' , 'hidden-xs' )
			)->appendChild
			(
				$this->navLang->appendChild
				(
					$this->navLang->addToAttribute( 'class' , 'MenuNavLang' )->applyCurrentLang
					(
						$container->setAttribute( 'class' , 'DOMLangTxtContainer' )->appendChild
						(
							new OffText( 'span' , gettext( ' Seleccionado : ' ) )
						)
					)->appendChild( new OffText( 'span' , '. Disponibles : ' ) )
				)
			)->appendChild
			(
				$this->nav->appendChild( $this->ul )->setAttribute( 'class' , 'MenuNavMain' )
			);



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

				$noIconClass=NULL;

				$s=0;
				while( isset( $opciones[$s] ) )
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

					if( isset( $opcion['TituloID'] ) )
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

					$iconUrl='/img/menu/'.$opcion['ContenidoID'].'.png';
					
					if( file_exists( $_SERVER['DOCUMENT_ROOT'] . $iconUrl ) )
					{
						if( $noIconClass===NULL )
						{
							$noIconClass='noIcon';
						}

						$opc->setIconUrl
						(
							$iconUrl
						);
					}
					else
					{
						$opc->addReferenceToAttr( 'class' , $noIconClass );
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

			$h2=new DOMTag('span');

			$img=new DOMTag('img');

			$labName=getLabName();
			$labNameContainer=new DOMTag( getLabNameContainer() , $labName );

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
								sprintf( gettext('Logo de %s') , $labName )
							)
						)->appendChild
						(
							$labNameContainer->setAttribute( 'class' , 'LabNameContainer' )
						)
					)
				)
			);

			return parent::renderChilds( $tag );
		}
	}
?>