<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Evts_List.php';

	class SQL_Evts_Comentarios_Normal implements SQL_Evts_List
	{
		public function edita()
		{
			//Include necesario para manejar llaves foráneas.
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Comentario.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Contenido.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';

			//Revisar.
			if(isset($_SESSION['RaizID']))
			{
				$_POST['RaizID']=$_SESSION['RaizID'];

				unset($_SESSION['RaizID']);
			}

			//Creo un objeto comentario.
			$FechaAct=getdate();
			$Fecha=	$FechaAct['year'].'-'
					.$FechaAct['mon'].'-'
					.$FechaAct['mday'].' '
					.$FechaAct['hours'].':'
					.$FechaAct['minutes'].':'
					.$FechaAct['seconds'];
			
			$Comentario=new Comentario();
			//Indico que tiene como foráneo un objeto Contenido.
			$Comentario->insForanea
			(
				nTraduccion
				(
					$_POST['Mensaje'][0],
					$_SESSION['lang']
				),
				'ContenidoID',
				'ContenidoID'
			);

			global $vRecID;

			if(isset($_POST['Nombre']))
			{
				$Comentario->Nombre=$_POST['Nombre'][0];
			}
			if(isset($_SESSION['conID']))
			{
				//echo '<pre>Padre=$_SESSION["comConID"]</pre>';

				$Comentario->PadreID=$_SESSION['conID'];

				unset($_SESSION['conID']);
			}
			else
			{
				//echo '<pre>Padre=$vRecID</pre>';
				$Comentario->PadreID=$_POST['RaizID'];
			}
			
			$Comentario->RaizID=$_POST['RaizID'];
			

			$Comentario->Fecha=$Fecha;

			//Inserto el comentario en la BD.
			$Comentario->insSQL();

			//Esto hace que se ancle el comentario al que está siendo respondido.
			//La idea es que se ancle el comentario recién creado, para lo que
			//a futuro hay que modificar insSQL() para que actualize el ID.
			$_SESSION['conID']=$Comentario->ContenidoID;	
		}
		public function nuevo()
		{
			return $this->edita();	
		}
		public function elimina()
		{
			echo '<pre>Nuevo Comentario (Normal)</pre>';
			
		}
	}

?>