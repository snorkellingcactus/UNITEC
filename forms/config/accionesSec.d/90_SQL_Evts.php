<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	$formLab=new FormCliRecv('Sec');
	$formLab->SQL_Evts=new SQL_Evts_Secciones();
	$formLab->checks();

	$this->redirect($this->getOriginUrl());
?>