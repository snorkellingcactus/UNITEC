<div class="contenedor">
	<form action="php/accion.php" method="POST" target="_blank" class="col-xs-12 col-sm-7 sm-6 col-md-6 col-lg-6">
		<h1 class="col-xs-12 col-xs-offset-0 col-all-12 all-12 all-offset-0">
				<?php echo gettext('Nos interesa tu opinión!')?>
		</h1>
		<div class="clearfix"></div>
		<div class="label">
			<label for="Correo" class="col-xs-12 col-sm-5 col-md-5 col-lg-5"><?php echo gettext('Correo')?>:</label>
			<input type="text" name="Correo" id="Correo" class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
		</div>

		<div class="clearfix"></div>

		<div class="label">
			<label for="Asunto" class="col-xs-12 col-sm-5 col-md-5 col-lg-5"><?php echo gettext('Asunto')?>:</label>
			<input type="text" name="Asunto" id="Asunto" class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
		</div>

		<div class="clearfix"></div>

		<div class="label">
			<label for="Mensaje" class="col-xs-12 col-sm-5 col-md-5 col-lg-5"><?php echo gettext('Mensaje')?>:</label>
			<textarea name="Mensaje" id="Mensaje" class="col-xs-12 col-sm-7 col-md-7 col-lg-7"></textarea>
		</div>

		<input type="hidden" name="form" value="accionesMail">

		<div class="clearfix"></div>
		<div class="label">
			<input type="submit" name="nuevo" value="<?php echo gettext('Enviar')?>" class="col-xs-12 col-xs-offset-0 col-all-12 all-12 all-offset-0">
		</div>
	</form>
</div>
<div class="info col-lg-6">
<?php
	$info=$this->info;

	function displaySocial($alt , $clave , $valor)
	{
		?>
			<div class="col-lg-6 col-xs-6 social">
				<a href="<?php echo $valor; ?>">
						<img class="circulo" alt="<?php echo sprintf($alt , $clave); ?>" src="/img/<?php echo $clave; ?>.png" />
						<i><?php echo $clave?></i>
				</a>
			</div>
		<?php
	}
	function clearFix()
	{
		?>
			<div class="clearfix"></div>
		<?php
	}

	$social=$this->social;
	$alt=gettext('Página de %s');

	clearFix();
	clearFix();

	if(!empty($social['Facebook']))
	{
		displaySocial($alt , 'Facebook' , $social['Facebook']);
	}
	if(!empty($social['Twitter']))
	{
		displaySocial($alt , 'Twitter' , $social['Twitter']);
	}

	if(!empty($social['Facebook']) || !empty($social['Twitter']))
	{
		?>
			<div class="clearboth"></div>
		<?php
	}

	if(!empty($info['Telefono']))
	{
		$str=gettext('Teléfono:');
		?>
			<p class="col-lg-6 col-xs-6">
				<img src="/img/Telefono.png" alt="<?php echo gettext('Mail')?>"/>
				<!--<b><?php echo $str?></b>-->
				<i><?php echo $info['Telefono']?></i>
			</p>
		<?php
	}
	if(!empty($info['Mail']))
	{
		$str=gettext('E-Mail:');
		?>
			<p class="col-lg-6 col-xs-6">
				<img src="/img/Mail.png" alt="<?php echo gettext('Mail')?>"/>
				<!--<b><?php echo $str?></b>-->
				<i>
					<a href="mailto:<?php echo $info['Mail'] ?>"><?php echo $info['Mail'] ?></a>
				</i>
			</p>
		<?php
	}
	if(!empty($info['DireccionID']))
	{
		$str=gettext('Dirección:');
		?>
			<p class="col-lg-6 col-xs-6">
				<img src="/img/DireccionID.png" alt="<?php echo gettext('Direccion')?>"/>
				<!--<b><?php echo $str?></b>-->
				<i><?php echo $info['DireccionID']?></i>
			</p>
		<?php
	}
	?>
</div>
<div class="clearfix"></div>
