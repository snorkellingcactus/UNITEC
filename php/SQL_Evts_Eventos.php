<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Evts_List.php';

	class SQL_Evts_Eventos implements SQL_Evts_List
	{
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Evento.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Traduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/updTraduccion.php';

			$evento=new Evento();

			$this->cantidad=count($_POST['Titulo']);
			$afectadosLen=0;
			$afectados=[];

			for($i=0;$i<$this->cantidad;$i++)
			{
				$evento->getSQL(['DescripcionID'=>$_SESSION['conID'][$i]]);
				$evento->getAsoc
				(
					[
						'Tiempo'=>$_POST['Ano'][$i].'-'.$_POST['Mes'][$i].'-'.$_POST['Dia'][$i].' '.$_POST['Horas'][$i].':'.$_POST['Minutos'][$i],
						'Visible'=>$_POST['Visible'][$i],
						'Prioridad'=>$_POST['Prioridad'][$i]
					]
				);

				updTraduccion($_POST['Descripcion'][$i] , $_SESSION['conID'][$i] , $_SESSION['lang']);
				updTraduccion($_POST['Titulo'][$i] , $evento->NombreID , $_SESSION['lang']);

				//echo '<pre>A insertar: ';print_r($evento);echo '</pre>';

				$evento->updSQL
				(
					false,
					[
						'DescripcionID'=>$_SESSION['conID'][$i]
					]
				);

				$afectados[$afectadosLen]=$_SESSION['conID'][$i];
				++$afectadosLen;
			}
			return $afectados;
		}
		public function nuevo()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Evento.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/nTraduccion.php';

			$this->cantidad=count($_POST['Titulo']);
			$afectadosLen=0;
			$afectados=[];

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
				$evento->insForanea
				(

					nTraduccion
					(
						$_POST['Titulo'][$i],
						$_SESSION['lang']
					),
					'NombreID',
					'ContenidoID'
				);

				$evento->insSQL();

				$afectados[$afectadosLen]=$evento->DescripcionID;
				++$afectadosLen;
			}
			return $afectados;
		}
		public function elimina()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
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