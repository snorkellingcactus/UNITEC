<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Imagenes.php';

	$formGalRecv=new FormCliRecv('Gal');
	$formGalRecv->SQL_Evts=new SQL_Evts_Imagenes();

	$formGalRecv->checks();

	$this->redirect($this->getOriginUrl());
?>