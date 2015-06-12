<?php
	//Si todavía no se inicio sesion, se inicia.
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();
	if(!isset($_SESSION['normalID']))
	{
		header('Location: http://'.$_SERVER['SERVER_NAME'].'/inicio_sesion.php');
		die();
	}

	$rw=1;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Visor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

	$visor	= new Visor($this->recLst);
	global $vRecID;
	
	$vRecID=$visor->recSel['vRecID'];

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';

	$comentariosHTML=new Include_Context($_SERVER['DOCUMENT_ROOT'] . '/esq/visor_comentarios.php');
	$comentariosHTML->ContenidoID=$visor->recSel['vRecID'];

	$this->include->data=$visor->recSel;

	$this->include->vRecSig=$visor->indexRecN($visor->nRecSel+1);
	$this->include->vRecAnt=$visor->indexRecN($visor->nRecSel-1);

	$this->include->getContent();
	$comentariosHTML->getContent();
?>