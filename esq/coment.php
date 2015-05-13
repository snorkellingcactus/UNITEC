<div class="comentario"
<?php
	if
	(
		(isset($_SESSION['comConID'])&&$_SESSION['comConID']==$esq['ContenidoID'])
	)
	{
		unset($_SESSION['comConID']);

		?>
			id="comRes" 
		<?php
	}
?>
>
	<p class='comAutor'>
		<?php
			echo $esq['Nombre'];

			?>
				<span class="comResTxt">
			<?php

			//Nombre de la persona respondida.
			if(isset($esq['NombreDest']))
			{
				?>
					&#8631; <?php echo $esq['NombreDest'] ?>
				<?php
			}

			//Intervalo de tiempo desde el envío del comentario.
			
			$RangoTiempo=['y' , 'm' , 'd' , 'h' , 'i' , 's'];
			$RTHumano=[' años' , ' meses' , ' dias' , ' horas' , ' minutos' , ' segundos'];

			$Fecha=new DateTime();
			$Fecha=$Fecha->createFromFormat('Y-m-d H:i:s' , $esq['Fecha']);
			$Fecha=$Fecha->diff(new DateTime() , true);

			$t=0;
			$tMax=5;

			while($Fecha->$RangoTiempo[$t]<=0 && $t<$tMax)
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
		<input type="hidden" name="comConID" value="<?php echo $esq['ContenidoID'] ?>" >
	 	<input type="submit" value="↶" title="Responder a <?php echo $esq['Nombre'] ?>">
	</form>

 	<?php
		if(isset($_SESSION['adminID']) && $_SESSION['adminID']!==NULL)
		 {
		 	?>
			 	<input type="checkbox" name="conID[]" value="<?php echo $esq['ContenidoID'] ?>" form="accionesCom">
		 	<?php
		 }
	?>


	<p class="comCont">
		<?php echo $esq['ValorCont'] ?>
	</p>

	<?php
		if(isset($_POST['comConID'])&&$_POST['comConID']==$esq['ContenidoID'])
		{
			$_SESSION['comConID']=$_POST['comConID'];
			echo file_get_contents("../forms/nuevo_coment.php");
		}
	?>
</div>