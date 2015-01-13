<?php
	$clase=['class="','class="muted ','class="muted ','class="evento '];
	$hoy=['pasado"','hoy"','"'];

	$clase=$clase[$esq->clase];

	$hoy=$hoy[$esq->hoy];
?>
<td <?php echo $clase.$hoy ?>>
	<p>
		<?php echo $esq->dia ?>
	</p>
</td>