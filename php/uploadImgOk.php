<?php
	function uploadImgOk($name)
	{
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