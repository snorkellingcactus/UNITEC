<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Evts_List.php';

	class SQL_Evts_Comentarios_Normal implements SQL_Evts_List
	{
		public function edita()
		{
			
		}
		public function nuevo()
		{
			//echo '<pre>Nuevo Comentario (Normal)</pre>';
			//Include necesario para manejar llaves foráneas.
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Comentario.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Contenido.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';

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
					$_POST['comContenido'],
					$_SESSION['lang']
				),
				'ContenidoID',
				'ContenidoID'
			);

			global $vRecID;

			if(isset($_POST['comNomUsuario']))
			{
				$Comentario->Nombre=$_POST['comNomUsuario'];
			}
			if(isset($_SESSION['comConID']))
			{
				//echo '<pre>Padre=$_SESSION["comConID"]</pre>';

				$Comentario->PadreID=$_SESSION['comConID'];

				unset($_SESSION['comConID']);
			}
			else
			{
				//echo '<pre>Padre=$vRecID</pre>';
				$Comentario->PadreID=$vRecID;
			}
			$Comentario->RaizID=$vRecID;
			$Comentario->Fecha=$Fecha;
/*
			echo '<pre>A insertar:';
			print_r('<br>Comentario : ');
			print_r($Comentario);
			echo '</pre>';
*/
			//Inserto el comentario en la BD.
			$Comentario->insSQL();

			//Esto hace que se ancle el comentario al que está siendo respondido.
			//La idea es que se ancle el comentario recién creado, para lo que
			//a futuro hay que modificar insSQL() para que actualize el ID.
			$_SESSION['comConID']=$Comentario->ContenidoID;
		}
		public function elimina()
		{
			
		}
	}

?>