<?php
	include 'php/Novedad.php';
	include 'php/Novedad_HTML.php';
?>
<section id='nov'>
	<?php
		$novedad=new Novedad_HTML(new Novedad);

		echo $novedad->gen();
     
	?>
</section>