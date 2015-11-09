<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Menu.php';

	$formLab=new FormCliRecv('Menu');
	$formLab->SQL_Evts=new SQL_Evts_Menu();
	$formLab->checks();

	$this->redirect($this->getOriginUrl());
?>