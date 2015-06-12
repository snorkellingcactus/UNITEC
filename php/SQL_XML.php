<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();

if(!empty($_SESSION['adminID']))
{
	$raiz=$_POST['raiz'];

	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_DOM.php';

	$SQLDOM=new SQL_DOM
	(
		$con,
		[
			'Val'=>$raiz,
			'Tipo'=>'Raiz'
		]
	);

	$SQLDOM->resArbolXML();
}

?>