<!DOCTYPE HTML >
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Página principal Unitec." />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<h1>Muchas gracias, su consulta fué enviada.</h1>
		<?php
			mail
			(
				'snorkellingcactus@gmail.com',
				$_POST['Asunto'],
				$_POST['Mensaje']."\nCorreo del consultante: ".$_POST['Correo'],
				'From: garciazavalanadal@gmail.com'
			);
		?>
	</body>
</html>