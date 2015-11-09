<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Novedades.php';

	$formLab=new FormCliRecv('Nov');
	$formLab->SQL_Evts=new SQL_Evts_Novedades();
	$formLab->checks();

	$this->redirect($this->getOriginUrl());
?>