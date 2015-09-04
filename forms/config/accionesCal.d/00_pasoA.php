<?php
	//echo '<pre>Paso A</pre>';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormCal.php';

	$this->form=new FormCal($this , $this->contador);
?>