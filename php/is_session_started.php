<?php
	/**
	* @return bool
	*/
	function is_session_started()
	{
		if(php_sapi_name() !== 'cli' )
		{
			if( version_compare(phpversion(), '5.4.0', '>=') )
			{
				if(session_status() === PHP_SESSION_ACTIVE)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else 
			{
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	function start_session_if_not()
	{
		if( is_session_started() === FALSE )
		{
			session_start();
		}
	}
?>