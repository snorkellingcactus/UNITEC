<!DOCTYPE HTML>
<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTMLImagenes.php';

	$html=new DOMHTMLImagenes();

	echo $html->getHTML();
?>