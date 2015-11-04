<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');

	function nTag($name)
	{
		global $con;
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php');

		$name=nTraduccion($name , $_SESSION['lang']);
		$name->insSQL();
/*
		echo '<pre>nTag:';
		print_r
		(
			'	INSERT INTO Tags(NombreID)
				VALUES('.$name->ContenidoID.')
			'
		);
		echo '</pre>';
*/
		$con->query
		(
			'	INSERT INTO Tags(NombreID)
				VALUES('.$name->ContenidoID.')
			'
		);

		return $con->insert_id;
	}
	function nTagsGrp()
	{
		global $con;
/*
		echo '<pre>nTagsGrp: Consulta:';
		print_r
		(
			'	INSERT INTO TagsGrp(ID) VALUES(NULL)'
		);
		echo '</pre>';
*/
		$con->query
		(
			'	INSERT INTO TagsGrp(ID) VALUES(NULL)
			'
		);
		return $con->insert_id;
	}
	function nTagsTargets($tags , $grupoID)
	{
		$tags=explode
		(
			',',
			$tags
		);

		$t=0;
		while(isset($tags[$t]))
		{
			nTagTarget
			(
				strtolower
				(
					preg_replace
					(
						"/\s+/",
						" ",
						trim($tags[$t])
					)
				),
				$grupoID
			);

			++$t;
		}
	}
	function nTagTarget($name , $grupoID)
	{
		global $con;

		$tagID=getDuplicatedTag($name);
		if($tagID===false)
		{
			$tagID=nTag($name);
			echo '<pre>nTagTarget: Nuevo Tag: '.$name.'</pre>';
		}
		else
		{
			echo '<pre>nTagTarget: Ignorando Tag Duplicado: '.$name.'</pre>';
		}
		if(!isDuplicatedTagTarget($tagID))
		{
			$con->query
			(
				'	INSERT INTO TagsTarget(TagID , GrupoID)
					VALUES('.$tagID.' , '.$grupoID.')
				'
			);
			echo '<pre>nTagTarget: Insertado TagTarget: '.$name.'</pre>';
		}
		else
		{
			echo '<pre>nTagTarget: Ignorando TagTarget duplicado: '.$name.'</pre>';
		}
	}
	function isDuplicatedTagTarget($tagID)
	{
		global $con;
/*
		echo '<pre>getDuplicatedTagTarget: Consulta:';
		print_r
		(
			'	SELECT 1
				FROM TagsTarget
				WHERE TagsTarget.TagID='.$tagID.'
				LIMIT 1
			'
		);
		echo '</pre>';
*/
		if
		(
			isset
			(
				fetch_all
				(
					$con->query
					(
						'	SELECT 1
							FROM TagsTarget
							WHERE TagsTarget.TagID='.$tagID.'
							LIMIT 1
						'
					),
					MYSQLI_NUM
				)[0][0]
			)
		)
		{
			return true;
		}
		return false;
	}
	function getDuplicatedTag($name)
	{
		global $con;
/*
		echo '<pre>getDuplicates: Consulta:';
		print_r
		(
			' 	SELECT Traducciones.ContenidoID
				FROM Tags
				LEFT OUTER JOIN Traducciones
				ON Traducciones.Texto="'.addslashes($name).'"
				WHERE Traducciones.ContenidoID=Tags.NombreID
				LIMIT 1
			'
		);
		echo '</pre>';
*/
		$duplicates=fetch_all
		(
			$con->query
			(
				' 	SELECT Tags.ID
					FROM Tags
					LEFT OUTER JOIN Traducciones
					ON Traducciones.Texto="'.addslashes($name).'"
					WHERE Traducciones.ContenidoID=Tags.NombreID
					LIMIT 1
				'
			),
			MYSQLI_NUM
		);
/*
		echo '<pre>getDuplicates: $duplicates:';
		print_r
		(
			$duplicates
		);
		echo '</pre>';
*/
		if(isset($duplicates[0][0]))
		{
			return $duplicates[0][0];
		}
		else
		{
			return false;
		}
	}
?>