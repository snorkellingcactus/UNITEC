<?php
	if
	(
		(isset($_POST['comResID'])&&$_POST['comResID']==$esq->ID) ||
		isset($_SESSION['comRes'])
	)
	{
		unset($_SESSION['comRes']);
		?>
			<span id="comRes"></span>
		<?php
	}
?>
<div class="comentario">
	<p class='comAutor'>
		<?php
			echo $esq->NombreUsuario;

			?>
				<span class="comResTxt">
			<?php

			//Nombre de la persona respondida.
			if(isset($esq->NombreDest))
			{
				?>
					&#8631; <?php echo $esq->NombreDest ?>
				<?php
			}

			//Intervalo de tiempo desde el envío del comentario.
			
			$RangoTiempo=['y' , 'm' , 'd' , 'h' , 'i' , 's'];
			$RTHumano=[' años' , ' meses' , ' dias' , ' horas' , ' minutos' , ' segundos'];

			$Fecha=new DateTime();
			$Fecha=$Fecha->createFromFormat('Y-m-d H:i:s' , $esq->Fecha);
			$Fecha=$Fecha->diff(new DateTime() , true);

			$t=0;

			while($Fecha->$RangoTiempo[$t]<=0)
			{
				++$t;
			}

			$buff=' - Hace '.$Fecha->$RangoTiempo[$t].$RTHumano[$t];
			?>
				<?php echo $buff ?></span>
			<?php
		?>
	</p>

	<form action="#comRes" method="POST" class="formRes">
		<input type="hidden" name="comResID" value="<?php echo $esq->ID ?>" >
	 	<input type="submit" value="↶" title="Responder a <?php echo $esq->NombreUsuario ?>">
	</form>

 	<?php
		if(isset($_SESSION['adminID']) && $_SESSION['adminID']!==NULL)
		 {
		 	?>
			 	<input type="checkbox" name="comID[]" value="<?php echo $esq->ID ?>" form="accionesCom">
		 	<?php
		 }
	?>


	<p class="comCont">
		<?php echo $esq->Contenido ?>
	</p>

	<?php
		if(isset($_POST['comResID'])&&$_POST['comResID']==$esq->ID)
		{
			$_SESSION['comResID']=$_POST['comResID'];
			echo file_get_contents("../forms/nuevo_coment.php");
		}
	?>
</div>