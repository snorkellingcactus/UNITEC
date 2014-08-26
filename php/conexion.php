<?php
	$Conexion=mysql_connect("localhost","root");

	mysql_select_db("unitec");
/*

	$consulta=mysql_query("select * from usuarios where Nombre='Admin'");
	
	$resA=mysql_fetch_array($consulta);
	$resB=mysql_query('update usuarios set Contrasena="'.sha1($resA['Contrasena']).'" where Contrasena="1234"');
	mysql_close($Conexion);
	
	foreach($resA as $clave => $valor)
	{
		if(isset($resA[$clave]))
		{
			echo 'Resultado '.$clave.' : '.$valor.'<br>';
		}
	}
	if($resB==0)
	{
		echo 'Error actualizando contrasena';
		echo 'update usuarios set Contrasena='.sha1($resA['Contrasena']).' where Contrasena=1234';
	}
*/
?>