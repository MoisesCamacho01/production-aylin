<h4 class="fw-bold py-3 mb-4">
	<span class="text-muted fw-light">Encargados /</span> Listado
	<?php foreach ($buttonTop as $row) : ?>
		<?php if ($row->id == 'BP001') : ?>
			<a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createModal">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
		<?php if ($row->id == 'BP0010') : ?>
			<a class="btn btn-info text-white" target="_blank" href="<?= site_url('pdf-managers') ?>">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
		<?php if ($row->id == 'BP0011') : ?>
			<a class="btn btn-danger text-white" href="<?= site_url('excel-managers') ?>">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</h4>
<!-- Basic Bootstrap Table -->
<div class="card">
	<h5 class="card-header">Encargados</h5>
	<div class="text-nowrap">
		<table class="table">
			<thead>
				<tr>
					<th>N</th>
					<th>Nombres Completos</th>
					<th>Teléfono</th>
					<th>Celular</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody class="table-border-bottom-0" id="bodyTable">

			</tbody>
		</table>
		<div id="loader" class="loader mt-4"></div>
	</div>
	<div class="card-footer text-right">
		<nav class="d-inline-block">
			<ul class="pagination mb-0" id="paginasContainer">
				<li class="page-item">
					<a class="page-link pageStart" href="#">INICIO</a>
				</li>
				<li class="page-item disabled" id="buttonBack">
					<a class="page-link page-left" href="#" tabindex="-1"><i class='bx bxs-left-arrow'></i></a>
				</li>

				<!-- AQUI SE PONEN LAS PAGINAS DE FORMA AUTOMATICA -->

				<li class="page-item">
					<a class="page-link page-right" href="#"><i class='bx bxs-right-arrow'></i></a>
				</li>
				<li class="page-item">
					<a class="page-link pageFinish" href="#">FINAL</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
<!--/ Basic Bootstrap Table -->

<!-- MODALES -->
<!-- MODAL CREAR-->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Nuevo Encargado</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="name" class="form-label">Nombres del Encargado</label>
						<input type="text" id="name" class="form-control" placeholder="Nombres Completos" />
						<span class="validate-text" name='name'></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="last_name" class="form-label">Apellidos del Encargado</label>
						<input type="text" id="last_name" class="form-control" placeholder="Apellidos del  Encargado" />
						<span class="validate-text" name='last_name'></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="phone" class="form-label">Teléfono del Encargado</label>
						<input type="text" id="phone" class="form-control" placeholder="Teléfono de casa" />
						<span class="validate-text" name='phone'></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="mobile" class="form-label">Celular del Encargado</label>
						<input type="text" id="mobile" class="form-control" placeholder="Teléfono cellular" />
						<span class="validate-text" name='mobile'></span>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Cancelar
				</button>
				<button type="button" id="btnCreate" class="btn btn-primary">Guardar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Actualizar Encargado</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="nameE" class="form-label">Nombres del Encargado</label>
						<input type="text" id="nameE" class="form-control" placeholder="Nombres completos" />
						<span class="validate-text" name='nameE'></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="last_nameE" class="form-label">Apellidos del Encargado</label>
						<input type="text" id="last_nameE" class="form-control" placeholder="Apellidos del  Encargado" />
						<span class="validate-text" name='last_nameE'></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="phoneE" class="form-label">Teléfono del Encargado</label>
						<input type="text" id="phoneE" class="form-control" placeholder="Teléfono del Encargado" />
						<span class="validate-text" name='phoneE'></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="mobileE" class="form-label">Celular del Encargado</label>
						<input type="text" id="mobileE" class="form-control" placeholder="Celular del Encargado" />
						<span class="validate-text" name='mobileE'></span>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Cancelar
				</button>
				<button type="button" id="btnUpdate" class="btn btn-primary">Actualizar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL ELIMINAR -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Eliminar Encargado</h5>
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
					Cancelar
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
				<h5 class="modal-title" id="exampleModalLabel1">Suspender Encargado</h5>
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
					Cancelar
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
				<h5 class="modal-title" id="exampleModalLabel1">Activar Encargado</h5>
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
					Cancelar
				</button>
				<button type="button" id="btnActive" data-bs-dismiss="modal" class="btn btn-primary">Activar</button>
			</div>
		</div>
	</div>
</div>

<!-- PAGINATOR -->
<input type="hidden" name="inicioPaginator" value="0">
<input type="hidden" name="cantidadPaginator" value="10">
<input type="hidden" name="pagePaginator" value="1">
<input type="hidden" name="cantidadRegistros" value="<?= $quantity ? $quantity : 10 ?>">
<input type="hidden" name="pagesLimit" value="4">
