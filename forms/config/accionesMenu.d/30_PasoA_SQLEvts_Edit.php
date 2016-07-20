<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepMenuBase.php';

	class PasoA_SQLEvts_Edit extends SrvStepMenuBase
	{
		function setRouter( SrvStepRouter &$router )
		{
			parent::setRouter( $router );

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$contentID=FormActions::getContentID()[0];

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Menu.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

			global $con;

			$session=new FormSession();
			$session->loadLabels( 'FileUrl', 'Icono' ); //¿Necesario?
			$session->autoloadLabels();

			//$afectados=[];

			updTraduccion
			(
				$session->getLabel('Titulo') ,
				$contentID ,
				$_SESSION['lang']
			);

			$nMenu=new Menu();

			$nMenu->Visible=intval
			(
				filter_var
				(
					$session->getLabel('Visible') ,
					FILTER_VALIDATE_BOOLEAN
				)
			);

			$nMenu->updSQL
			(
				false ,
				[
					'ContenidoID'=>$contentID
				]
			);
			$nMenu->getSQL
			(
				[
					'ContenidoID'=>$contentID
				]
			);

			updTraduccion( $session->getLabel('Url') , $nMenu->UrlID , $_SESSION['lang'] );
			updTraduccion( $session->getLabel('FileUrl') , $nMenu->UrlIconID , $_SESSION['lang'] );

			$hasIcon=intval
			(
				filter_var
				(
					$session->getLabel('Icono') ,
					FILTER_VALIDATE_BOOLEAN
				)
			) === 1;

			//Revisar .Redundancia interna en los chequeos.
			if
			(
				$hasIcon &&
				(
					(
						$this->getUploadUrl
						(
							$session->getLabel( 'FileUrl' ) ,
							getTraduccion
							(
								$nMenu->UrlIconID ,
								$_SESSION['lang']
							)
						) !== false
					) ||
					!$this->isImgFileEmpty( 0 )
				)
			)
			{
				$this->mkUpload( 0 , $nMenu->ContenidoID , $session );
			}

			$icon_path=$_SERVER['DOCUMENT_ROOT'] . '/img/menu/'.$nMenu->ContenidoID.'.png';

			if( !$hasIcon && file_exists( $icon_path ) )
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/elimina.php';
				elimina( $icon_path , 0755 );
			}

			if($session->hasLabel('Tags'))
			{
				$nMenu->updTagsTargets($session->getLabel('Tags'));

				$nMenu->PrioridadesGrpID=fetch_all
				(
					$con->query
					(
						'	SELECT PrioridadesGrpID
							FROM Menu
							WHERE ID='.$nMenu->ID
					),
					MYSQLI_NUM
				)[0][0];

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

				updLabsTagsPriority
				(
					$session->getLabel('Tags'),
					$nMenu,
					'1',
					$session->getLabel('Lugar'),
					'ContenidoID',
					true
				);
			}

			//$afectados[$i]=$conIdAct;
			
			//return $afectados;

			$router->gotoOrigin();
		}
	}
?>