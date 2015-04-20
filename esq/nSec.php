<form class="nSec" action="php/accion.php" method="POST" >
	<?php
		if(isset($orden))
		{
			$iMax=count($orden);

			for($i=0;$i<$iMax;$i++)
			{
				if(!isset($orden[$i]))
				{
					++$iMax;
					continue;
				}
				?>
					<input type="hidden" name="lleno[]" value="<?php echo $i?>" >
				<?php
			}
		}
	?>
	<input type="hidden" name="form" value="accionesSec">
	<button type="submit" name="nuevas"><h1>+</h1></button>
</form>