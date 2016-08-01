<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMInclude.php';

	class Modulo_Galeria extends DOMInclude
	{
		function renderChilds( &$tag )
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

			$this->setAdminFormName( 'FormCliGal' );

			$imgLst=getPriorizados
			(
				fetch_all
				(
					$con->query
					(
						'	SELECT Imagenes.*
							FROM Imagenes
							LEFT OUTER JOIN TagsTarget
							ON TagsTarget.GrupoID=Imagenes.TagsGrpID
							LEFT OUTER JOIN Laboratorios
							ON Laboratorios.ID='.$_SESSION['lab'].'
							WHERE TagsTarget.TagID=Laboratorios.TagID '.
							$this->getFilterVisible().$this->getFilterLimit()
					),
					MYSQLI_ASSOC
				)
			);

			if( isset( $imgLst[0] ) )
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMGalImg.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

				$form=$this->getAdminForm();

				$lName=getLabName();
				$i=0;

				while( isset( $imgLst[$i] ) )
				{
					$imgAct=& $imgLst[$i];

					$img=new DOMGalImg();

					$fecha=new DateTime
					(
						date
						(
							$imgAct['Fecha']
						)
					);

					$this->appendChild
					(
						$img->setTitulo
						(
							getTraduccion
							(
								$imgAct['TituloID'],
								$_SESSION['lang']
							)
						)->setAlt
						(
							getTraduccion
							(
								$imgAct['AltID'],
								$_SESSION['lang']
							)
						)->setSrc
						(
							'/img/miniaturas/galeria/'.$imgAct['ID'].'.png'
						)->setUrl
						(
							//Revisar . Código en común con VisorImagenes, DOMMenuOpc, Modulo_Novedades , Modulo_Imagenes
							getLangCode()				.
							'/espacios/'				.
							$lName						.
							'/galeria/'					.
							$fecha->format('Y-m-d')		.
							'/'							.
							str_replace
							(
								['%2F' , '%3F' , '%2C'] ,
								'' ,
								urlencode
								(
									$img->titulo
								)
							)							.
							'-'.$imgAct['ID']
						)
					);
					
					//$imgAct['afectado']=false;
					
					if( $form !== false )
					{
						$img->setActionCheckBox
						(
							$form->buildActionCheckBox
							(
								$imgAct['TituloID']
							)
						);
					}

					++$i;
				}

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

				$this->appendChild(new ClearFix());

				$limit=$this->getLimit();

				if( $limit !==false && isset( $imgLst[$limit-1] ) )
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMVerMas.php';

					$this->appendChild
					(
						new DOMVerMas
						(
							'/?vRecID='.$this->sID,
							gettext('Ver todas las imágenes')
						)
					);
				}
			}
			else
			{
				$this->appendChild
				(
					new DOMTag
					(
						'p',
						gettext( 'No hay imágenes para mostrar.' )
					)
				);
			}

			return parent::renderChilds( $tag );
		}
	}
?>