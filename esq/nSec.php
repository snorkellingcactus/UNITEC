<form class="nSec" action="php/accion.php" method="POST" >
	<?php
		if(isset($secciones))
		{
			$iMax=count($secciones);

			for($i=0;$i<$iMax;$i++)
			{
				?>
					<input type="hidden" name="lleno[]" value="<?php echo $secciones[$i]['Prioridad']?>" >
				<?php
			}
		}
	?>
	<input type="hidden" name="form" value="accionesSec">
	<button type="submit" name="nuevas"><h1>+</h1></button>
</form>