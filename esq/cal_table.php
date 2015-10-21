<table summary="<?php echo sprintf(gettext('Calendario de %1$s del %2$s') , $this->fecha['month'] , $this->fecha['year']) ?>">
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