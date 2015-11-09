<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Labs.php';

	$formLab=new FormCliRecv('Lab');
	$formLab->SQL_Evts=new SQL_Evts_Labs();
	$formLab->checks();

	$this->redirect($this->getOriginUrl());
?>