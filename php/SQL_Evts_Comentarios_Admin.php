<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_List.php';

	class SQL_Evts_Comentarios_Admin implements SQL_Evts_List
	{
		public function edita()
		{
			
		}
		public function nuevo()
		{
			//Include necesario para manejar llaves foráneas.
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Comentario.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Contenido.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';

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
				$Comentario->Nombre=htmlentities($_POST['comNomUsuario']);
			}
			if(isset($_SESSION['comConID']))
			{
				$Comentario->PadreID=$_SESSION['comConID'];

				unset($_SESSION['comConID']);
			}
			else
			{
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
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			global $con;
			$conID=$_SESSION['conID'];

			$iMax=count($conID);
			for($i=0;$i<$iMax;$i++)
			{
				$con->query('DELETE FROM Contenidos WHERE ID='.$conID[$i]);

				echo '<pre>'.'DELETE FROM Contenidos WHERE ID='.$conID[$i].'</pre>';
			}

			unset($_SESSION['conID'] , $_SESSION['form']);
		}
	}

?>