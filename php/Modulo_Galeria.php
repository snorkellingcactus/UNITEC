<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMInclude.php';

	class Modulo_Galeria extends DOMInclude
	{
		function renderChilds(&$doc , &$tag)
		{
			if(isset($_SESSION['imgLst']))
			{
				unset($_SESSION['imgLst']);
			}

			if(isset($_SESSION['adminID']))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliGal.php';
				
				$this->appendChild
				(
					$formGal=new FormCliGal()
				);
			}
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/opciones.php';
					
			$limit=getValFromNombreID('limit' , $this->opcGrpID , $this->opcSetsID);

			if($this->limit && is_array($limit) && $limit[0]!=='0')
			{
				$limit=$limit[0];
				$limitStr='LIMIT '.$limit;
			}
			else
			{
				$limit=$limitStr=false;
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

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
							WHERE TagsTarget.TagID=Laboratorios.TagID
						'.$limitStr
					),
					MYSQLI_ASSOC
				)	//Respuesta SQL como array asociativo.
			);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMGalImg.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';

			if(isset($imgLst[0]))
			{
				$lName=getLabName();
				$i=0;

				while(isset($imgLst[$i]))
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
							getLangCode().
							'/espacios/'.
							$lName.
							'/galeria/'.
							$fecha->format('Y-m-d').
							'/'.
							urlencode($img->titulo).
							'-'.$imgAct['ID']
						)
					);
					
					//$imgAct['afectado']=false;
					
					if(isset($formGal))
					{
						$img->setActionCheckBox
						(
							$formGal->buildActionCheckBox
							(
								$imgAct['TituloID']
							)
						);
					}	

					++$i;
				}

				if($limit!==false && isset($imgLst[$limit-1]))
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
						gettext('No hay imágenes para mostrar.')
					)
				);
			}

			return parent::renderChilds($doc , $tag);
		}
	}
?>