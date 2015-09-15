<table summary="Calendario de <?php echo $this->fecha['month'] ?> de <?php echo $this->fecha['year']?>">
	<thead>
		<tr>
			<?php $esq->genTheadTrThMes(); ?>
		</tr>
		<tr>
			<?php $esq->genTheadTrThDias(); ?>
		</tr>
	</thead>
	<tbody>
		<?php $esq->genTbody(); ?>
	</tbody>
</table>