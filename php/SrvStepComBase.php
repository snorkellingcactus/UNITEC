<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class SrvStepComBase extends SrvStepBase
	{
		private $parentID;

		function setParentID($parentID)
		{
			$this->parentID=$parentID;
		}
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
		
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Comentario.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			echo '<pre>$_SESSION:';
			print_r
			(
				$_SESSION
			);
			echo '</pre>';

			echo '<pre>$_POST:';
			print_r
			(
				$_POST
			);
			echo '</pre>';

			$contentID=FormActions::getContentID();

			$session=new FormSession();
			$session->loadLabels( 'Mensaje' , 'Nombre' , 'RaizID' );

			//$afectados=[];
			
			$Comentario=new Comentario();
			
			$Comentario->insForanea
			(
				nTraduccion
				(
					$session->getLabel( 'Mensaje' ),
					$_SESSION['lang']
				),
				'ContenidoID',
				'ContenidoID'
			);

			if( $session->hasLabel( 'Nombre' ) )
			{
				$Comentario->Nombre=$session->getLabel( 'Nombre' );
			}

			$Comentario->PadreID=$this->parentID;
			
			$Comentario->RaizID=$session->getLabel( 'RaizID' );
			
			$FechaAct=getdate();

			$Comentario->Fecha=	$FechaAct['year']	.'-'.
								$FechaAct['mon']	.'-'.
								$FechaAct['mday']	.' '.
								$FechaAct['hours']	.':'.
								$FechaAct['minutes'].':'.
								$FechaAct['seconds'];

			$Comentario->insSQL();

			//Esto hace que se ancle el comentario al que está siendo respondido.
			//La idea es que se ancle el comentario recién creado, para lo que
			//a futuro hay que modificar insSQL() para que actualize el ID.
			//$_SESSION['conID']=$Comentario->ContenidoID;	

		}
	}
?>