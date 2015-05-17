<?
	function cargaMenu()
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';

		global $con;

		$secciones=$con->query
		(
			'	SELECT * FROM Secciones
				WHERE MenuID IS NOT NULL 
				ORDER BY Prioridad ASC
			'
		);

		$secciones=fetch_all($secciones);

		$sMax=count($secciones);

		echo '<pre>sMax : '.$sMax;echo '</pre>';
	}
?>
<nav class='menuSup visible-xs'>
		<a href="#sobre">Inicio</a>
		<a href="#nov"	>Novedades</a>
		<a href="#labs"	>Espacios de extensión</a>
		<a href="#cal"	>Eventos</a>
		<a href="#gal"	>Galería</a>
		<a href="#"		>Idioma</a>
		<a href="#"		>Accesibilidad</a>
		<a href="#"		>Iniciar Sesión</a>
</nav>
<div class="col-xs-2 col-sm-2 col-lg-2">
	<div class="menu hidden-xs">
		<!--	:::::::::Menú:::::::::	-->
		<nav>
			<ul>			
				<li>
					<a href="#29" tabindex="1">Inicio</a>
				</li>
				<li>
					<a href="#33"	 tabindex="1">Novedades</a>
				</li>
				<li>
					<a href="#labs"	 tabindex="1">Espacios de extensión</a>
				</li>
				<li>
					<a href="#35"	 tabindex="1">Eventos</a>
				</li>
				<li>
					<a href="#37"	 tabindex="1">Galería</a>
				</li>
				<li>
					<a href="#39"	 tabindex="1">Mapa</a>
				</li>
				<li>
					<a href="#"		 tabindex="1">Accesibilidad</a>
				</li>
			</ul>
		</nav>
		<!-- Logo -->
		<div>
			<h2>
				<img src="img/logo_unitec.png" alt="Unitec Logo" width="80" height="80"/>
				UNITEC
			</h2>
		</div>
	</div>
</div>