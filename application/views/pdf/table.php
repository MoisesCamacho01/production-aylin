<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?= $title ? $title : 'PDF' ?></title>
</head>
<style>
	.text-center{
		text-align: center;
	}
	.row{
		width: 100%;
	}
	.col{
		width: 100%;
	}
	.table{
		width: 100%;
		border-collapse: collapse;
	}

	th, td{
		text-align: center;
  		padding: 8px;
	}

	th{
		background-color: #312783;
		border: 1px solid #5C5C5C;
		color: #fff;
	}
	td{
		border: 1px solid black;
	}

	.logotipo{
		width: 100%;
	}
	.logotipo .img{
		width: 30%;
		height: 50px;
		margin-left: auto;
		margin-right: auto;
	}
	.logotipo .img img{
		width: 100%;
		object-fit: cover;
	}

	.logotipo .text{
		margin-top: -15px;
		text-align: center;
		text-transform: uppercase;
	}
	.logotipo .text h6{
		margin: 0px;
		padding: 0px;
	}
	.mayus{
		text-transform: uppercase;
	}

</style>
<body>
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="logotipo">
					<div class="img">
						<img src="<?=base_url('resources/src/img/logo-ciya.png')?>">
					</div>
					<div class="text">
						<h6>sistema PDF</h6>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<h1 class="text-center mayus"><?= $titleDocument ? $titleDocument : 'Documento en Blanco'?></h1>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<table class="table">
					<thead>
						<tr>
							<?php for ($i=0; $i< count($thead); $i++): ?>
								<th><?= $thead[$i]?></th>
							<?php endfor; ?>
						</tr>
					</thead>
					<tbody>
						<?php if(count($tbody)>0): $i=0; ?>
							<?php foreach ($tbody as $row): $i++; ?>

							<tr>
								<td><?= $i ?></td>
								<?php
									// Obtener todas las propiedades del objeto como un array asociativo
									$row_vars = get_object_vars($row);
									unset($row_vars['id']); // ELIMINAR LA id
									unset($row_vars['action']); // ELIMINAR LA action
								?>
								<?php foreach ($row_vars as $value):?>
									<td><?= $value ?></td>
								<?php endforeach;?>

								<?php if(isset($row->action)):?>
									<td>
										<?php if($row->action == 'create'): ?>
											<span>ACTIVO</span>
										<?php elseif($row->action == 'suspend'): ?>
											<span>SUSPENDIDO</span>
										<?php elseif($row->action == 'edit'):?>
											<span>EDITADO</span>
										<?php elseif($row->action == 'delete'):?>
											<span>ELIMINADO</span>
										<?php endif;?>
									</td>
								<?php endif;?>
							</tr>
							<?php endforeach; ?>
						<?php else: ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>

</html>
