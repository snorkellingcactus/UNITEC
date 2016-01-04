<!-- Comentarios -->
<div class="comentarios col-lg-10 col-md-10 col-sm-10 col-xs-10" >
	<?php
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/FormSrvRecv.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php');
		global $vRecID;

		$vRecID=$this->ContenidoID;

		$formHandler=new FormCliRecv('Com');
		$formCom=false;

		//Incluyo las acciones posibles.
		if(isset($_SESSION['adminID']))
		{
			//include_once($_SERVER['DOCUMENT_ROOT'] . '/php/FormCliBuilder.php');
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSelBase.php';
			include_once($_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Comentarios_Admin.php');

			$SQL_Evts=new SQL_Evts_Comentarios_Admin();

			$formCom=new FormCliSelBase('accionesCom');

			echo $formCom->getHTML();
		}
		else
		{
			include_once($_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Comentarios_Normal.php');

			$SQL_Evts=new SQL_Evts_Comentarios_Normal();
		}

		if(isset($_POST['nuevo']))
		{
			$formRecv=new FormSrvRecv('Com');
		}
		$formHandler->SQL_Evts=$SQL_Evts;
		$formHandler->checks();
		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/Comentario.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
		global $con;


		
		//Genero los comentarios.
		GenComGrp($this->ContenidoID , $con , $formCom);

		if(!isset($_POST['comConID']))
		{
			include_once($_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php');
			$formCom=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/forms/nuevo_coment.php');

			$formCom->getContent();
		}
	?>
</div>
<div class="clearfix"></div>