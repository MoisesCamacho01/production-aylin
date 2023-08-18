<h4 class="fw-bold py-3 mb-4">
	<span class="text-muted fw-light"><?= $parish->name ?> /</span> Barrios

	<!--<a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createModal">
		AÑADIR
	</a>
	<a class="btn btn-info text-white" target="_blank" href="<?= site_url('pdf/districs') ?>">
		PDF
	</a>
	<a class="btn btn-danger text-white" href="<?= site_url('excel/districts') ?>">
		EXCEL
	</a>-->
	<?php foreach ($buttonTop as $row): ?>
		<?php if($row->id == 'BP001') : ?>
			<a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createModal">
				<?= $row->name?>
			</a>
		<?php endif; ?>
		<?php if($row->id == 'BP0010') : ?>
			<a class="btn btn-info text-white" target="_blank" href="<?= site_url('pdf-districts/'.$parish->id) ?>">
				<?= $row->name?>
			</a>
		<?php endif; ?>
		<?php if($row->id == 'BP0011') : ?>
			<a class="btn btn-danger text-white" href="<?= site_url('excel-districts/'.$parish->id) ?>">
				<?= $row->name?>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</h4>
<!-- Basic Bootstrap Table -->
<div class="card">
	<h5 class="card-header">Barrios</h5>
		<div class="table-responsive text-nowrap">
			<table class="table">
				<thead>
					<tr>
						<th>N</th>
						<th>Nombre</th>
						<th>Parroquia</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody class="table-border-bottom-0" id="bodyTable">

				</tbody>
			</table>
		</div>
		<div class="card-footer text-right">
			<nav class="d-inline-block">
				<ul class="pagination mb-0" id="paginasContainer">
					<li class="page-item disabled" id="buttonBack">
						<a class="page-link page-left" href="#" tabindex="-1"><i class='bx bxs-left-arrow'></i></a>
					</li>

					<?php for ($i = 1; $i <= round(($quantity + 1) / 6); $i++) : ?>
						<li class="page-item <?= $i == 1 ? 'active' : ''; ?>">
							<a class="page-link btnPages" href="#"><?= $i ?></a>
						</li>
					<?php endfor; ?>

					<li class="page-item">
						<a class="page-link page-right" href="#"><i class='bx bxs-right-arrow' ></i></a>
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
				<h5 class="modal-title" id="exampleModalLabel1">Nuevo Barrio</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="name" class="form-label">Nombre del Barrio</label>
						<input type="text" id="name" class="form-control" placeholder="Nombre del barrio" />
						<span class="validate-text" name="name"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="institutionsE" class="form-label">Parroquia</label>
                  <input type="text" id="NameCiudad" class="form-control" disabled value="<?=$parish->name?>" placeholder="Ingrese una ciudad" />
						<input type="hidden" id="parish" value="<?=$parish->id?>">
						<span class="validate-text" name="parish"></span>
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
				<h5 class="modal-title" id="exampleModalLabel1">Actualizar Barrio</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="nameE" class="form-label">Nombre de la Barrio</label>
						<input type="text" id="nameE" class="form-control" placeholder="Nombre de la extensión" />
						<span class="validate-text" name="nameE"></span>
					</div>
				</div>

				<div class="row">
					<div class="col-12 mb-2">
						<label for="NameCiudad" class="form-label">Parroquia</label>
                  <input type="text" id="NameCiudad" class="form-control" disabled value="<?=$parish->name?>" placeholder="Ingrese una ciudad" />
						<input type="hidden" id="parishE" value="<?=$parish->id?>">
						<span class="validate-text" name="parishE"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Close
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
				<h5 class="modal-title" id="exampleModalLabel1">Eliminar Barrio</h5>
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
				<h5 class="modal-title" id="exampleModalLabel1">Suspender Barrio</h5>
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
				<h5 class="modal-title" id="exampleModalLabel1">Activar Barrios</h5>
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

<input type="hidden" name="idInstitution" value="<?= $parish->id?>" >

<!-- PAGINATOR -->
<input type="hidden" name="inicioPaginator" value="0">
<input type="hidden" name="cantidadPaginator" value="10">
<input type="hidden" name="pagePaginator" value="1">
<input type="hidden" name="cantidadRegistros" value="<?= $quantity ? $quantity : 10 ?>">
<input type="hidden" name="pagesLimit" value="4">
