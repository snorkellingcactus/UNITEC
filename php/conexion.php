<?php
	function fetch_all($mysqliObj , $modo)
	{
		$res=[];
		$j=0;

		if(!$mysqliObj)
		{
			return $res;
		}
		
		while($row=$mysqliObj->fetch_array($modo))
		{
			$res[$j]=$row;
			++$j;
		}

		return $res;
	}
	
	global $con;

	$usuario='ro';
	if(isset($_SESSION['adminID']) || !empty($rw))
	{
		$usuario='root';
	}

	//$con=new mysqli('host','usuario','passwd','bd');	//Casa Gonza.
	$con=new mysqli('localhost',$usuario,'s2r9v3->149','edetec');	//Casa Gonza.

	unset($usuario);
?>