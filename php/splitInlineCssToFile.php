<?php
	function splitInlineCssToFile( $content , $content_id )
	{
		$f_name=$_SERVER['DOCUMENT_ROOT'].'/css/generated/'.$content_id.'.css';

		file_put_contents( $f_name , '' );
		
		//http://stackoverflow.com/a/20432621/4818797
		return preg_replace_callback
		(
			'/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i',
			function ( $match ) use ( $content_id , $f_name )
			{
				static $s_len=0;

				$id='s'.$content_id.$s_len;

				file_put_contents
				(
					$f_name ,
					'#'.$id.'{'.str_replace( '"' , '' , $match[2]).'}'."\n",
					FILE_APPEND
				);

				++$s_len;

				return $match[1].' id="'.$id.'" '.$match[3];
			},
			$content
		);
	}
?>