<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Eventos.php';

	$formLab=new FormCliRecv('Cal');
	$formLab->SQL_Evts=new SQL_Evts_Eventos();
	$formLab->checks();

	$this->redirect($this->getOriginUrl());
?>