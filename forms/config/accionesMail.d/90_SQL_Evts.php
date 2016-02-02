<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Labs.php';

	$formLab=new FormCliRecv('Mail');
	$formLab->checks();

	$this->redirect($this->getOriginUrl());
?>