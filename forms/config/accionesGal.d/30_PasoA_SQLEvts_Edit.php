<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepImgUploadBase.php';

	class PasoA_SQLEvts_Edit extends SrvStepImgUploadBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			echo '<pre>$_SESSION:';
			print_r($_SESSION);
			echo '</pre>';
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/elimina.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			//$afectados=[];

			$contentID=FormActions::getContentID();
			
			$session=new FormSession();

			global $con;

			foreach( $contentID as $index=>$contentIDAct )
			{
				$session->setIDSuffix( $index );
				$session->autoloadLabels();
				$session->loadLabels( 'Url' );
				
				$nImg=new Img();

				$nImg->getSQL
				(
					[
						'TituloID'=>$contentIDAct
					]
				);

/*
				//Revisar. ¿Debería autocompletar las URLs?
				if($nImg->Url!=='/img/miniaturas/galeria/'.$_POST['Url'][$i])
				{
					//echo '<pre>Intentando eliminar imagen</pre>';
					//$nImg->Fecha=date("Y-m-d H:i:s");

					elimina($_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/galeria/'.$nImg->ID.'.png' , 0775);
					elimina($_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/visor/'.$nImg->ID.'.png' , 0775);
				}
*/

				$nImg->getAsoc
				(
					[
						'Url'=>$session->getLabel('Url') ,
						'Visible'=>$session->getLabel('Visible') ,
					]
				);

				$nImg->updSQL(false , ['TituloID']);

				updTraduccion
				(
					$session->getLabel('Titulo')  ,
					$nImg->TituloID ,
					$_SESSION['lang']
				);
				updTraduccion
				(
					$session->getLabel('Alt')  ,
					$nImg->AltID ,
					$_SESSION['lang']
				);



				$this->mkUpload($index , $nImg->ID , $session);

				if(!$session->emptyTrimLabel( 'Tags' ))
				{
					$nImg->updTagsTargets
					(
						$session->getLabel( 'Tags' )
					);

					updTagsPriority
					(
						$session->getLabel( 'Tags' ) ,
						$session->getLabel( 'Prioridad' ) ,
						$nImg
					);
				}
			}

			//$afectados[$i]=$conIdAct;
			
			//return $afectados;

			//$this->router->gotoOrigin();
		}
	}
?>