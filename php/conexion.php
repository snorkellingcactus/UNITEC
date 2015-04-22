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
	
	//$con=new mysqli('host','usuario','passwd','bd');	//Casa Gonza.
?>