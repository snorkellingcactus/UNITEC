<div class="novedades">
	<?php
		//::::::::::Variables de Sesion::::::::::::::
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
		start_session_if_not();
		//Cache por defecto vale 0.
		if(!isset($_SESSION['cache']))
		{
			$_SESSION['cache']=0;
		}
		//Invierto el valor boleano de cache.
		if(isset($_GET['cache']))
		{
			$_SESSION['cache']=!$_GET['cache']||0;
		}
		//:::::::::HTML y Diálogos:::::::::::
		//Diferencias al ser admin.
		if(!empty($_SESSION['adminID']))
		{
			include_once($_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliNov.php');
			
			$formNov=new FormCliNov();
			echo $formNov->getHTML();
		}

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
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

		$novedades=getPriorizados
		(
			fetch_all
			(
				$con->query
				(
					'	SELECT Novedades.* FROM `Novedades`
						LEFT OUTER JOIN TagsTarget
						ON TagsTarget.GrupoID=Novedades.TagsGrpID
						LEFT OUTER JOIN Laboratorios
						ON Laboratorios.ID='.$_SESSION['lab'].'
						WHERE TagsTarget.TagID=Laboratorios.TagID
						ORDER BY Fecha DESC
					'.$limitStr
				),
				MYSQLI_ASSOC
			)
		);

		if(!isset($novedades[0]))
		{
			?>
				<p><?php echo gettext('Sin novedades') ?></p>
			<?php
		}
		else
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/html2text/html2text.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMNovedad.php';

			$i=0;
			while(isset($novedades[$i]))
			{
				$novedadHTML=new DOMNovedad();
				$novAct=$novedades[$i];

				if(isset($formNov))
				{
					$novedadHTML->setCheckBox
					(
						$formNov->buildActionCheckBox($novAct['ID'])
					);
				}

				
				$descripcion=getTraduccion
				(
					$novAct['DescripcionID'],
					$_SESSION['lang']
				);
				

				$descTrim=trim($descripcion);

				if(!empty($descTrim))
				{
					$novedadHTML->setDescripcion
					(
						substr
						(
							convert_html_to_text
							(
								$descTrim
							),
							0,
							500
						)
					);
				}

				

				//Revisar.A futuro guardar en la db una version en texto plano.
				$novedadHTML->setTitulo
				(
					getTraduccion
					(
						$novAct['TituloID'],
						$_SESSION['lang']
					)
				)->setFechaFromYmdHis
				(
					$novAct['Fecha']
				)->setImgSrc
				(
					'/img/miniaturas/galeria/'.$novAct['ImagenID'].'.png'
				)->setImgAlt
				(
					getTraduccion
					(
						fetch_all
						(
							$con->query
							(
								'	SELECT AltID
									FROM Imagenes
									WHERE ID='.$novAct['ImagenID']
							),
							MYSQLI_NUM
						)[0][0],
						$_SESSION['lang']
					)
				)->setFullUrl
				(
					'/'.
					getLangCode().
					'/espacios/'.
					getLabName().
					'/novedades/'.
					strftime
					(
						'%Y-%m-%d',
						$novedadHTML->fecha
					).
					'/'.
					urlencode
					(
						str_replace
						(
							'/',
							' ',
							$novedadHTML->titulo
						)
					).
					'-'.
					$novAct['ID']
				);

				if
				(
					isset($formNovRecv->afectados) &&
					in_array($novAct['TituloID'] , $formNovRecv->afectados)
				)
				{
					$novedadHTML->afectado=true;
				}
				else
				{
					$novedadHTML->afectado=false;
				}

				echo $novedadHTML->getHTML();

				++$i;
			}
			if($limit!==false && isset($novedades[$limit-1]))
			{
				?>
					<div class="ver-mas">
						<a href="/?vRecID=<?php echo $this->secID?>" ><?php echo gettext('Ver todas las novedades') ?></a>
					</div>
				<?php
			}
		}
 
	?>
</div>