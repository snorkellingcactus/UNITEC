<?php
	function printBool($bool)
	{	
		if
		(
			filter_var
			(
				$bool ,
				FILTER_VALIDATE_BOOLEAN
			)
		)
		{
			return 'true';
		}

		return 'false';
	}
?>