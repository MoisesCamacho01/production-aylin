<!-- API DE GOOGLE MAPS -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0Ko6qUa0EFuDWr77BpNJOdxD-QLstjBk&libraries=places,geometry,drawing&callback=initMap" defer>
</script>
<!-- -->
<link rel="stylesheet" href="<?=base_url('resources/librerias/leaflet/leaflet.css'); ?>" />


<h4 class="fw-bold py-3 mb-4">
	<span class="text-muted fw-light">Cantones /</span> Listado
	<?php foreach ($buttonTop as $row) : ?>
		<?php if ($row->id == 'BP001') : ?>
			<a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createModal">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
		<?php if ($row->id == 'BP0010') : ?>
			<a class="btn btn-info text-white" target="_blank" href="<?= site_url('pdf-cities') ?>">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
		<?php if ($row->id == 'BP0011') : ?>
			<a class="btn btn-danger text-white" href="<?= site_url('excel-cities') ?>">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>

</h4>
<!-- Basic Bootstrap Table -->
<div class="card">
	<h5 class="card-header">Cantones</h5>
	<div class="text-nowrap">
		<table class="table">
			<thead>
				<tr>
					<th>N</th>
					<th>Nombre</th>
					<th>Provincia</th>
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

				<?php for ($i = 1; $i <= round(($quantity + 1) / 6); $i++): ?>
					<li class="page-item <?= $i == 1 ? 'active' : ''; ?>">
						<a class="page-link btnPages" href="#">
							<?= $i ?>
						</a>
					</li>
				<?php endfor; ?>

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
				<h5 class="modal-title" id="exampleModalLabel1">Nuevo cantón</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="name" class="form-label">Nombre del cantón</label>
						<input type="text" id="name" class="form-control" placeholder="Nombre del cantón" />
						<span class="validate-text" name="name"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="countries" class="form-label">Países</label>
							<?php if (count($countries) > 0) : ?>
								<?php foreach ($countries as $row) : ?>
									<?php if ($row->id == 'C001') : ?>
										<input type="text" id="countryC" class="form-control" disabled value="<?= $row->name ?>" placeholder="Ingrese una ciudad" />
										<input type="hidden" id="countries" value="<?= $row->id ?>">
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						<span class="validate-text" name="countries"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="states" class="form-label">Provincias</label>
							<?php if (count($states) > 0) : ?>
								<?php foreach ($states as $row) : ?>
									<?php if ($row->id == '12') : ?>
										<input type="text" id="stateC" class="form-control" disabled value="<?= $row->name ?>" placeholder="Ingrese una ciudad" />
										<input type="hidden" id="states" value="<?= $row->id ?>">
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						<span class="validate-text" name="states"></span>
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
				<h5 class="modal-title" id="exampleModalLabel1">Actualizar canton</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="nameE" class="form-label">Nombre del cantón</label>
						<input type="text" id="nameE" class="form-control" placeholder="Nombre de la ciudad" />
						<span class="validate-text" name="nameE"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="countriesE" class="form-label">Países</label>
							<?php if (count($countries) > 0) : ?>
								<?php foreach ($countries as $row) : ?>
									<?php if ($row->id == 'C001') : ?>
										<input type="text" id="country" class="form-control" disabled value="<?= $row->name ?>" placeholder="Ingrese una ciudad" />
										<input type="hidden" id="countriesE" value="<?= $row->id ?>">
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						<span class="validate-text" name="countriesE"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="statesE" class="form-label">Provincias</label>
							<?php if (count($states) > 0) : ?>
								<?php foreach ($states as $row) : ?>
									<?php if ($row->id == '12') : ?>
										<input type="text" id="state" class="form-control" disabled value="<?= $row->name ?>" placeholder="Ingrese una ciudad" />
										<input type="hidden" id="statesE" value="<?= $row->id ?>">
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						<span class="validate-text" name="statesE"></span>
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
				<h5 class="modal-title" id="exampleModalLabel1">Eliminar Canton</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
					<p class="text-danger">Si eliminas este canton las alarmas de este cantón no se podrán usar</p>
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
				<h5 class="modal-title" id="exampleModalLabel1">Suspender Cantón</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<p class="text-danger">Si suspendes este canton las alarmas de este cantón no se podrán usar</p>
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
				<h5 class="modal-title" id="exampleModalLabel1">Activar Cantón</h5>
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

<!-- MODAL DIBUJAR -->
<div class="modal fade" id="dibujarModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel4">Dibujar Mapa</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div class="loaderModal loader mt-4 ocultar"></div>
						<div id="map" class="mapa ocultar"></div>
						<input type="hidden" name="cords" value="">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info btnNuevo disabled">
					Nuevo dibujo
				</button>
				<button type="button" class="btn btn-info btnMB" data-bs-toggle="modal" data-bs-target="#modalBorrarPolygon">
					Borrar dibujo
				</button>
				<button type="button" class="btn btn-success btnMover">
					Mover dibujo
				</button>
				<button type="button" class="btn btn-danger btnNoMover disabled">
					No mover dibujo
				</button>
				<button type="button" class="btn btn-outline-secondary btnCloseModal" data-bs-dismiss="modal">
					Cancelar
				</button>
				<button type="button" id="btnSaveDraw" data-bs-dismiss="modal" class="btn btn-primary">Guardar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL PARA ASEGURAR BORRAR-->
<div class="modal fade" id="modalBorrarPolygon" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Borrar dibujo</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="usernameE" class="form-label">¿Seguro quieres borrar el dibujo?</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-target="#dibujarModal" data-bs-toggle="modal">
					Cancelar
				</button>
				<button type="button" data-bs-target="#dibujarModal" data-bs-toggle="modal" class="btn btn-primary btnBorrar">Aceptar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL VISUALIZAR DIBUJO -->
<div class="modal fade" id="viewMapModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel4">Visualizar Mapa</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div class="loaderModal loader mt-4 ocultar"></div>
						<div id="viewMap" class="mapa"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Cancelar
				</button>
				<!-- <button type="button" id="btnSaveDraw" data-bs-dismiss="modal" class="btn btn-primary">Guardar</button> -->
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="idInstitution" value="">
<!-- PAGINATOR -->
<input type="hidden" name="inicioPaginator" value="0">
<input type="hidden" name="cantidadPaginator" value="10">
<input type="hidden" name="pagePaginator" value="1">
<input type="hidden" name="cantidadRegistros" value="<?= $quantity ? $quantity : 10 ?>">
<input type="hidden" name="pagesLimit" value="4">
