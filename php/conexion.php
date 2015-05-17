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

	//$con=new mysqli('host','usuario','passwd','bd');	//Casa Gonza.
	$con=new mysqli('localhost','root','s2r9v3->149','edetec');	//Casa Gonza.
?>