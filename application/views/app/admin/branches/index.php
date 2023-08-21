<h4 class="fw-bold py-3 mb-4">
	<span class="text-muted fw-light"><?= $institution->name ?> /</span> Extensiones
	<!-- <a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createModal">
		Nueva Extension
	</a> -->
	<?php foreach ($buttonTop as $row): ?>
		<?php if($row->id == 'BP001') : ?>
			<a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createModal">
				<?= $row->name?>
			</a>
		<?php endif; ?>
		<?php if($row->id == 'BP0010') : ?>
			<a class="btn btn-info text-white" target="_blank" href="<?= site_url('pdf-branches') ?>">
				<?= $row->name?>
			</a>
		<?php endif; ?>
		<?php if($row->id == 'BP0011') : ?>
			<a class="btn btn-danger text-white" href="<?= site_url('excel-branches') ?>">
				<?= $row->name?>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</h4>
<!-- Basic Bootstrap Table -->
<div class="card">
	<h5 class="card-header">Ciudades</h5>
		<div class="table-responsive text-nowrap">
			<table class="table">
				<thead>
					<tr>
						<th>N</th>
						<th>Nombre</th>
						<th>Teléfono</th>
						<th>Celular</th>
						<th>Dirección</th>
						<th>Institución</th>
						<th>País</th>
						<th>Estado</th>
						<th>Ciudad</th>
						<th>Estado</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody class="table-border-bottom-0" id="bodyTable">

				</tbody>
			</table>
			<div id="loader" class="loader mt-4"></div>
		</div>
</div>
<!--/ Basic Bootstrap Table -->

<!-- MODALES -->
<!-- MODAL CREAR-->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Nueva Extension</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="name" class="form-label">Nombre de la Extensión</label>
						<input type="text" id="name" class="form-control" placeholder="Nombre de la extensión" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="address" class="form-label">Dirección</label>
						<input type="text" id="address" class="form-control" placeholder="Nombre de la extensión" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="phone" class="form-label">Teléfono</label>
						<input type="number" id="phone" class="form-control" placeholder="Ingrese el número telefónico" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="mobile" class="form-label">Teléfono Celular</label>
						<input type="number" id="mobile" class="form-control" placeholder="Ingrese el número celular" />
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="NameInstitution" class="form-label">Institución</label>
						<input type="text" id="NameInstitution" class="form-control" disabled value="<?=$institution->name?>" placeholder="Ingrese el número celular" />
						<input type="hidden" id="institutions" value="<?=$institution->id?>">

					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="countries" class="form-label">Países</label>
                  <select id="countries" class="form-select">
                     <option selected>Selecciona un país</option>
							<?php if(count($countries)>0): ?>
								<?php foreach ($countries as $row): ?>
									<option value="<?= $row->id?>"><?= $row->name?></option>
								<?php endforeach;?>
							<?php endif;?>
                  </select>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="states" class="form-label">Provincias</label>
                  <select id="states" class="form-select">
                     <option selected>Selecciona una Provincia</option>
							<?php if(count($states)>0): ?>
								<?php foreach ($states as $row): ?>
									<option value="<?= $row->id?>"><?= $row->name?></option>
								<?php endforeach;?>
							<?php endif;?>
                  </select>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="cities" class="form-label">Ciudad</label>
                  <select id="cities" class="form-select">
                     <option selected>Selecciona una Ciudad</option>
							<?php if(count($cities)>0): ?>
								<?php foreach ($cities as $row): ?>
									<option value="<?= $row->id?>"><?= $row->name?></option>
								<?php endforeach;?>
							<?php endif;?>
                  </select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Cancelar
				</button>
				<button type="button" id="btnCreate" data-bs-dismiss="modal" class="btn btn-primary">Guardar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Actualizar Extension</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="nameE" class="form-label">Nombre de la Extensión</label>
						<input type="text" id="nameE" class="form-control" placeholder="Nombre de la extensión" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="addressE" class="form-label">Dirección</label>
						<input type="text" id="addressE" class="form-control" placeholder="Nombre de la extensión" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="phoneE" class="form-label">Teléfono</label>
						<input type="number" id="phoneE" class="form-control" placeholder="Ingrese el número telefónico" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="mobileE" class="form-label">Teléfono Celular</label>
						<input type="number" id="mobileE" class="form-control" placeholder="Ingrese el número celular" />
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="institutionsE" class="form-label">Institución</label>
                  <input type="text" id="NameInstitution" class="form-control" disabled value="<?=$institution->name?>" placeholder="Ingrese el número celular" />
						<input type="hidden" id="institutionsE" value="<?=$institution->id?>">
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="countryE" class="form-label">Países</label>
                  <select id="countryE" class="form-select">
                     <option selected>Selecciona un país</option>
							<?php if(count($countries)>0): ?>
								<?php foreach ($countries as $row): ?>
									<option value="<?= $row->id?>"><?= $row->name?></option>
								<?php endforeach;?>
							<?php endif;?>
                  </select>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="statesE" class="form-label">Provincias</label>
                  <select id="statesE" class="form-select">
                     <option selected>Selecciona una Provincia</option>
							<?php if(count($states)>0): ?>
								<?php foreach ($states as $row): ?>
									<option value="<?= $row->id?>"><?= $row->name?></option>
								<?php endforeach;?>
							<?php endif;?>
                  </select>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="cityE" class="form-label">Ciudad</label>
                  <select id="cityE" class="form-select">
                     <option selected>Selecciona una Ciudad</option>
							<?php if(count($cities)>0): ?>
								<?php foreach ($cities as $row): ?>
									<option value="<?= $row->id?>"><?= $row->name?></option>
								<?php endforeach;?>
							<?php endif;?>
                  </select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Close
				</button>
				<button type="button" id="btnUpdate" data-bs-dismiss="modal" class="btn btn-primary">Actualizar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL ELIMINAR -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Eliminar Extensión</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="usernameE" class="form-label">¿Seguro quieres eliminar este registro?</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Close
				</button>
				<button type="button" id="btnDelete" data-bs-dismiss="modal" class="btn btn-primary">Eliminar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL SUSPENDER -->
<div class="modal fade" id="suspendModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Suspender Ciudad</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="usernameE" class="form-label">¿Seguro quieres suspender este registro?</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Close
				</button>
				<button type="button" id="btnSuspend" data-bs-dismiss="modal" class="btn btn-primary">Suspender</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL ACTIVAR -->
<div class="modal fade" id="activeModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Activar Ciudad</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="usernameE" class="form-label">¿Seguro quieres activar este registro?</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Close
				</button>
				<button type="button" id="btnActive" data-bs-dismiss="modal" class="btn btn-primary">Activar</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="idInstitution" value=<?= $institution->id?>
