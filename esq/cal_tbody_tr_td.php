<?php
	$clase=['class="','class="muted ','class="muted ','class="evento '];
	$hoy=['pasado"','hoy"','"'];

	$clase=$clase[$esq->clase].$hoy[$esq->hoy];

	//Previene clases vacías.
	if($clase=='class=""')
	{
		$clase='';
	}
?>
<td <?php echo $clase ?>>
	<p>
		<?php echo $esq->dia ?>
	</p>
</td>