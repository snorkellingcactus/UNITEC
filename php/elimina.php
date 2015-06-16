<?php
	function elimina($ruta , $chmod=false)
	{
		if(file_exists($ruta))
		{
			//echo '<pre>Chmod '.var_dump($chmod).' '.$ruta.' Fallido:</pre>';
			if($chmod!==false && !chmod($ruta , $chmod))
			{
				return false;
			}
			//echo 'Unlink '.$ruta.' Fallido';
			if(!unlink($ruta))
			{
				return false;
			}
		}

		return true;
	}
?>