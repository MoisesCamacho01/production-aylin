<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Autorización de Cambio de Contraseña</title>
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
	<h1>Autorización de Cambio de Contraseña</h1>
	<p>Se ha solicitado un cambio de contraseña para tu cuenta.</p>
	<p>Si no has solicitado este cambio, por favor ignora este mensaje.</p>
	<a class="button" style="color:white;" href="<?=site_url('validate-code/'.$token)?>">Autorizar Cambio de Contraseña</a>
</body>

</html>
