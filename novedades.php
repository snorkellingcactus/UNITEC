<!DOCTYPE HTML>
<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTMLNovedades.php';

	$html=new DOMHTMLNovedades();

	echo $html->getHTML();
?>