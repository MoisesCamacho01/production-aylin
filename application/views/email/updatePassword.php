<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Actualización de contraseña</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			text-align: center;
		}

		h1, p {
			color: #333333;
		}

		.button {
			display: inline-block;
			background-color: #312783;
			border: none;
			padding: 10px 20px;
			text-align: center;
			text-decoration: none;
			font-size: 16px;
			font-weight: bold;
			margin: 20px auto;
			cursor: pointer;
		}

		.button:hover {
			background-color: #5f61e6;
		}
	</style>
</head>

<body>
	<h1>Actualización de contraseña exitoso</h1>
	<p>¡Excelente! Tu contraseña ha sido cambiada exitosamente. Ahora puedes acceder a tu cuenta con tu nueva contraseña. Si tienes alguna pregunta o necesitas ayuda adicional, no dudes en contactarnos. ¡Gracias por confiar en nosotros!</p>
	<a class="button" style="color:white;" href="<?=site_url('login')?>">Iniciar sesión</a>
</body>

</html>
