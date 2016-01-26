<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';

	$formCom=new FormCliRecv('Com');

	if(isset($_SESSION['adminID']))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Comentarios_Admin.php';

		$formCom->SQL_Evts=new SQL_Evts_Comentarios_Admin();
	}
	else
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Comentarios_Normal.php';

		$formCom->SQL_Evts=new SQL_Evts_Comentarios_Normal();
	}

	$formCom->checks();

	$this->redirect($this->getOriginUrl());
?>