<h4 class="fw-bold py-3 mb-4">
	<span class="text-muted fw-light">Sectores</span>
</h4>

<div class="card">
	<h5 class="card-header">Sectores</h5>
	<div class="card-body">
		<div class="row">
			<div class="col-12 mb-2">
				<label for="ciudad" class="form-label">Cantones</label>
				<select id="ciudad" class="form-select">
					<option value="" selected>Seleccione un cantón</option>
					<?php if (count($cities) > 0) : ?>
						<?php foreach ($cities as $row) : ?>
							<option value="<?= $row->id ?>"><?= $row->name ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
				<span class="validate-text" name='ciudad'></span>
			</div>
		</div>

		<div class="row">
			<div class="col-12 mb-2">
				<label for="parroquia" class="form-label">Parroquias</label>
				<select id="parroquia" class="form-select">
					<option value="" selected>Seleccione una parroquia</option>
				</select>
				<span class="validate-text" name='parroquia'></span>
			</div>
		</div>

		<div class="row">
			<div class="col-12 mb-2">
				<label for="barrio" class="form-label">Barrios</label>
				<select id="barrio" class="form-select">
					<option value="" selected>Seleccione un barrio</option>
				</select>
				<span class="validate-text" name='barrio'></span>
			</div>
		</div>

		<div class="row">
			<div class="col-12 mb-2">
				<button type="button" id="btnIr" class="btn btn-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="idC" value="">
<input type="hidden" name="submenu" value="<?=$submenu?>">
