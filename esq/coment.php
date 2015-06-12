<div class="comentario"
<?php
	if
	(
		(isset($_SESSION['comConID'])&&$_SESSION['comConID']==$this->ContenidoID)
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
			echo $this->Nombre;

			?>
				<span class="comResTxt">
			<?php

			//Nombre de la persona respondida.
			if($this->NombreDest!==NULL)
			{
				?>&#8631;<?php

				echo $this->NombreDest;
			}

			//Intervalo de tiempo desde el envío del comentario.
			
			$RangoTiempo=['y' , 'm' , 'd' , 'h' , 'i' , 's'];
			$RTHumano=[' años' , ' meses' , ' dias' , ' horas' , ' minutos' , ' segundos'];

			$Fecha=new DateTime();
			$Fecha=$Fecha->createFromFormat('Y-m-d H:i:s' , $this->Fecha);
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
		<input type="hidden" name="comConID" value="<?php echo $this->ContenidoID ?>" >
	 	<input type="submit" value="↶" title="Responder a <?php echo $this->Nombre ?>">
	</form>

 	<?php
 		if($this->formBuilder!==false)
		{
			$this->formBuilder->buildActionCheckBox($this->ContenidoID);
		}
	?>


	<p class="comCont">
		<?php echo $this->ValorCont ?>
	</p>

	<?php
		if(isset($_POST['comConID'])&&$_POST['comConID']==$this->ContenidoID)
		{
			$_SESSION['comConID']=$_POST['comConID'];
			include $_SERVER['DOCUMENT_ROOT'] . '//forms/nuevo_coment.php';
		}
	?>
</div>