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
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliBase.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$this->span->appendChild
			(
				( new DOMTag( 'h1' , gettext( 'Fuente ' ) ) )->addToAttribute( 'class' , 'titulo' )
			)->appendChild
			(
				( new FormCliBase( 'accionesFuente' ) )->appendChild
				(
					( new FormInput( 'image' ) )->setAttribute( 'alt' , gettext( 'Aumentar' ) )->setValue('A+')->setName( FormActions::FORM_ACTION_PREFIX.FormActions::FORM_ACTIONS_NEW )->setCol( [ 'xs'=>6 , 'sm'=>6 , 'md'=>6 , 'lg'=>6 ] )->addToAttribute( 'class' , 'zoom-more' )
				)->appendChild
				(
					( new FormInput( 'image' ) )->setAttribute( 'alt' ,  gettext( 'Disminuir' ) )->setValue('A-')->setName( FormActions::FORM_ACTION_PREFIX.FormActions::FORM_ACTIONS_DELETE )->setCol( [ 'xs'=>6 , 'sm'=>6 , 'md'=>6 , 'lg'=>6 ] )->addToAttribute( 'class' , 'zoom-minus' )
				)->appendChild
				(
					( new FormInput( 'image' ) )->setAttribute( 'alt' , gettext( 'Reestablecer' ) )->setValue('A')->setName( FormActions::FORM_ACTION_PREFIX.FormActions::FORM_ACTIONS_EDIT )->setCol( [ 'xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12 ] )->addToAttribute( 'class' , 'zoom-reset' )
				)->addToAttribute('class' , 'zoom')
			);

			$this->navLang=new DOMLangUnitec();

			$this->span->appendChild
			(
				(
					new DOMTag( 'h1' , gettext( 'Idioma ' ) )
				)->addToAttribute( 'class' , 'titulo' )
			)->appendChild
			(
				$this->navLang->appendChild
				(
					$this->navLang->addToAttribute( 'class' , 'MenuNavLang' )->applyCurrentLang
					(
						( new DOMTag('span') )->setAttribute
						(
							'class',
							'DOMLangTxtContainer'
						)->appendChild
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
			if( !isset( $_SESSION['adminID'] ) )
			{
				$condVisible='AND Menu.Visible=1';
			}

			if( $_SESSION['lab']!==false )
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

					$opc=
						(
							new DOMMenuOpc
							(
								getTraduccion
								(
									$opcion['ContenidoID'],
									$_SESSION['lang']
								)
							)
						)->setAbsoluteUrl( $this->absoluteUrls );

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

			if( isset( $_SESSION['adminID'] ) )
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSecAddMenu.php';
				
				$this->span->appendChild
				(
					new FormCliSecAddMenu()
				);
			}

			$labName=getLabName();

			$this->span->appendChild
			(
				( new DOMTag('div') )->addToAttribute('class' , 'hidden-xs')->appendChild
				(
					( new DOMTag('span') )->appendChild
					(
						( new DOMLink() )->addToAttribute('class' , 'focuseable')->setUrl
						(
							'#header'
						)->setAttribute
						(
							'accesskey' ,
							'i'
						)->appendChild
						(
							( new DOMTag('img') )->setAttribute
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
							(
								new DOMTag( getLabNameContainer() , $labName )
							)->setAttribute( 'class' , 'LabNameContainer' )
						)
					)
				)
			);

			return parent::renderChilds( $tag );
		}
	}
?>