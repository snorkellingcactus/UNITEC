<!-- Comentarios -->
<div class="comentarios col-lg-10 col-md-10 col-sm-10 col-xs-10" >
	<?php
		include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormSrvRecv.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormCliRecv.php');

		$formHandler=new FormCliRecv('Com');

		//Incluyo las acciones posibles.
		if(isset($_SESSION['adminID']))
		{
			include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/FormCliBuilder.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_Comentarios_Admin.php');

			$SQL_Evts=new SQL_Evts_Comentarios_Admin();

			$formCom=new FormCliBuilder('Com' , 0);

			$formCom->buildActionForm();
		}
		else
		{
			include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_Comentarios_Normal.php');

			$SQL_Evts=new SQL_Evts_Comentarios_Normal();
		}

		if(isset($_POST['nuevo']))
		{
			$formRecv=new FormSrvRecv('Com');
		}
		$formHandler->SQL_Evts=$SQL_Evts;
		$formHandler->checks();

		include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Comentario.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php');
		global $con;


		
		//Genero los comentarios.
		GenComGrp($this->ContenidoID , $con);

		if(!isset($_POST['comConID']))
		{
			include_once($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Include_Context.php');
			$formCom=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/nuevo_coment.php');

			$formCom->getContent();
		}
	?>
</div>
<div class="clearfix"></div>