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
	
	$con=new mysqli('localhost','root','s2r9v3->149','edetec');	//Casa Gonza.
?>
