<!DOCTYPE html >
<?php
	//Si todavía no se inicio sesion, se inicia.
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTMLInicioSesion.php';

	$html=new DOMHTMLInicioSesion();

	echo $html->getHTML();
?>