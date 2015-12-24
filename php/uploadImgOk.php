<?php
	function uploadImgOk($name)
	{
		$name=trim($name);
		if(empty($name))
		{
			return false;
		}
		$uploadOk=false;
			
		$extension=strtolower
		(
			pathinfo
			(
				$name,
				PATHINFO_EXTENSION
			)
		);
		if
		(
			$extension=='png'	|| $extension=='jpg' ||
			$extension=='jpeg'	|| $extension=='gif'
		)
		{
			return true;
		}
		return false;
	}
?>