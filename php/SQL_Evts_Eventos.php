<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_List.php';

	class SQL_Evts_Eventos implements SQL_Evts_List
	{
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Evento.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Traduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/updTraduccion.php';

			$evento=new Evento();

			$this->cantidad=count($_POST['Titulo']);

			for($i=0;$i<$this->cantidad;$i++)
			{
				$evento->getAsoc
				(
					[
						'Tiempo'=>$_POST['Ano'][$i].'-'.$_POST['Mes'][$i].'-'.$_POST['Dia'][$i].' '.$_POST['Horas'][$i].':'.$_POST['Minutos'][$i],
						'Nombre'=>$_POST['Titulo'][$i],
						'Visible'=>$_POST['Visible'][$i],
						'Prioridad'=>$_POST['Prioridad'][$i]
					]
				);

				updTraduccion($_POST['Descripcion'][$i] , $_SESSION['conID'][$i] , $_SESSION['lang']);

				//echo '<pre>A insertar: ';print_r($evento);echo '</pre>';

				$evento->updSQL
				(
					false,
					[
						'DescripcionID'=>$_SESSION['conID'][$i]
					]
				);
			}
		}
		public function nuevo()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Evento.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';

			$this->cantidad=count($_POST['Titulo']);

			for($i=0;$i<$this->cantidad;$i++)
			{
				//$grupo=$con->query('select ifnull(max(Grupo),0) as Grupo from Contenido');
				
				//$grupo=fetch_all($grupo , MYSQLI_ASSOC)[0]['Grupo']+1;

				$fecha=date
				(
					'Y-m-d H:i:s',
					mktime
					(
						$_POST['Horas'][$i],
						$_POST['Minutos'][$i],
						0,
						$_POST['Mes'][$i],
						$_POST['Dia'][$i],
						$_POST['Ano'][$i]
					)
				);

				$evento=new Evento
				(
					[
						'Nombre'=>htmlentities($_POST['Titulo'][$i]),
						'Tiempo'=>$fecha,
						'Prioridad'=>$_POST['Prioridad'][$i]
					]
				);
				$evento->insForanea
				(

					nTraduccion
					(
						$_POST['Descripcion'][$i],
						$_SESSION['lang']
					),
					'DescripcionID',
					'ContenidoID'
				);

				$evento->insSQL();
			}	
		}
		public function elimina()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			global $con;

			$iMax=count($_SESSION['conID']);

			for($i=0;$i<$iMax;$i++)
			{
				//echo '<pre>Elimina Evento: '.'delete from Contenidos where ID='.$_SESSION['conID'][$i].'</pre>';
				$con->query('delete from Contenidos where ID='.$_SESSION['conID'][$i]);
			}
		}
	}

?>