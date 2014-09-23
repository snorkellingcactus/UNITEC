<?php
	include 'php/Gal_HTML.php';
?>
<section id="gal">
	<?php
		$Img=
		[
			'http://www.nocturnar.com/imagenes/fotos/wallpapers-fondos-de-pantalla-wallpaper-wallpaper-lampadas-wallpapers.jpg',
			'http://techbeasts.com/wp-content/uploads/2014/04/Wallpaper-HD.jpg',
			'http://www.ghulmil.com/wp-content/uploads/rainy-weather-hd-wallpaper.jpg',
			'http://techbeasts.com/wp-content/uploads/2014/04/hd-wallpaper-46.jpg',
			'http://cdn.wonderfulengineering.com/wp-content/uploads/2014/01/digital-wallpaper-1.jpg',
			'http://www.hdwallpapersinn.com/wp-content/uploads/2014/08/8589130446148-3d-view-abstract-blue-black-dark-cubes-reflections-wallpaper-hd.jpg',
			'http://www.hdwallpapers.in/walls/tron_lamborghini_aventador-HD.jpg'
		];

		$Gal=new Gal_HTML($Img);
		echo $Gal->gen();
	
	?>
</section>