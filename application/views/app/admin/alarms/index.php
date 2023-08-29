<!-- API DE GOOGLE MAPS -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0Ko6qUa0EFuDWr77BpNJOdxD-QLstjBk&libraries=places,geometry,drawing&callback=initMap" defer>
</script>
<!--  -->


<h4 class="fw-bold py-3 mb-4">
	<span class="text-muted fw-light" id="backButton" >
		<?= $sector->name ?> /
	</span> Alarmas

	<?php foreach ($buttonTop as $row): ?>
		<?php if ($row->id == 'BP001'): ?>
			<a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createModal" id="btnNewAlarm">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
		<?php if ($row->id == 'BP0010'): ?>
			<a class="btn btn-info text-white" target="_blank" href="<?= site_url('pdf-alarms') ?>">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
		<?php if ($row->id == 'BP0011'): ?>
			<a class="btn btn-danger text-white" href="<?= site_url('excel-alarms') ?>">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</h4>
<!-- Basic Bootstrap Table -->
<div class="card">
	<h5 class="card-header">Alarmas</h5>
	<div class="table-responsive text-nowrap">
		<table class="table">
			<thead>
				<tr>
					<th>N</th>
					<th>Nombre</th>
					<th>Encargado</th>
					<th>Barrio</th>
					<th>Estado</th>
					<th>Actions</th>
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
			</ul>
		</nav>
	</div>
</div>
<!--/ Basic Bootstrap Table -->

<!-- MODALES -->
<!-- MODAL CREAR-->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Nueva Alarma</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12 col-lg-6">
						<div class="row">
							<div class="col mb-3">
								<label for="code" class="form-label">Código de la Alarma</label>
								<input type="text" id="code" class="form-control" placeholder="Código de la alarma" />
								<span class="validate-text" name="code"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-12 mb-2">
								<label for="manager" class="form-label">Encargado</label>
								<select id="manager" class="form-select">
									<option selected>Selecciona un Encargado</option>
									<?php if (count($managers) > 0): ?>
										<?php foreach ($managers as $row): ?>
											<option value="<?= $row->id ?>"><?= $row->name ?> 		<?= $row->last_name ?></option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
								<span class="validate-text" name="manager"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-12 mb-2">
								<label for="NameCiudad" class="form-label">Sector</label>
								<input type="text" id="NameCiudad" class="form-control" disabled value="<?= $sector->name ?>"
									placeholder="Ingrese una ciudad" />
								<input type="hidden" id="sector" value="<?= $sector->id ?>">
								<span class="validate-text" name="sector"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-12 mb-2 mt-2">
								<label class="form-label">Ubicación de la alarma</label>
							</div>
							<div class="col-6 mb-2 mt-2">
								<input type="text" id="latitude" class="form-control" disabled value=""
									placeholder="latitude" />
								<span class="validate-text" name="latitude"></span>
							</div>
							<div class="col-6 mb-2 mt-2">
								<input type="text" id="longitude" class="form-control" disabled value=""
									placeholder="longitude" />
								<span class="validate-text" name="longitude"></span>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="row">
							<div class="col-12 mb-2 mt-2">
								<div id="mapLocationAlarm" class="" style="border: none; width: 100%; height: 70vh;"></div>
								<input type="hidden" name="cordsAlarm" value="">
							</div>
						</div>
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
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Actualizar Encargado</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12 col-lg-6">
						<div class="row">
							<div class="col mb-3">
								<label for="codeE" class="form-label">Nombre de la Alarma</label>
								<input type="text" id="codeE" class="form-control" placeholder="Nombre de la extensión" />
								<span class="validate-text" name="codeE"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-12 mb-2">
								<label for="managerE" class="form-label">Encargado</label>
								<select id="managerE" class="form-select">
									<option selected>Selecciona un Encargado</option>
									<?php if (count($managers) > 0): ?>
										<?php foreach ($managers as $row): ?>
											<option value="<?= $row->id ?>"><?= $row->name ?> 		<?= $row->last_name ?></option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
								<span class="validate-text" name="managerE"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-12 mb-2">
								<label for="NameCiudad" class="form-label">Sector</label>
								<input type="text" id="NameCiudad" class="form-control" disabled value="<?= $sector->name ?>"
									placeholder="Ingrese una ciudad" />
								<input type="hidden" id="sectorE" value="<?= $sector->id ?>">
								<span class="validate-text" name="sectorE"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-12 mb-2 mt-2">
								<label class="form-label">Ubicación de la alarma</label>
							</div>
							<div class="col-6 mb-2 mt-2">
								<input type="text" id="latitudeE" class="form-control" disabled value=""
									placeholder="latitude" />
								<span class="validate-text" name="latitudeE"></span>
							</div>
							<div class="col-6 mb-2 mt-2">
								<input type="text" id="longitudeE" class="form-control" disabled value=""
									placeholder="longitude" />
								<span class="validate-text" name="longitudeE"></span>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="row">
							<div class="col-12 mb-2 mt-2">
								<div id="mapLocationAlarmE" class="" style="border: none; width: 100%; height: 70vh;"></div>
								<input type="hidden" name="cordsAlarmE" value="">
							</div>
						</div>
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
				<h5 class="modal-title" id="exampleModalLabel1">Eliminar Barrio</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<p class="text-danger">Si eliminas esta alarma, no se podrá activar</p>
						<label class="form-label">¿Seguro quieres eliminar este registro?</label>
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
				<h5 class="modal-title" id="exampleModalLabel1">Suspender alarma</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
					<p class="text-danger">Si suspendes esta alarma, no se podrá activar</p>
						<label class="form-label">¿Seguro quieres suspender este registro?</label>
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
				<h5 class="modal-title" id="exampleModalLabel1">Activar Barrios</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label class="form-label">¿Seguro quieres activar este registro?</label>
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
						<label class="form-label">¿Seguro quieres borrar el dibujo?</label>
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
					<div class="col-12 bg-gray">
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

<input type="hidden" name="idInstitution" value="<?= $sector->id ?>">
<input type="hidden" id="lat" name="lat" value="">
<input type="hidden" id="lng" name="lng" value="">


<!-- PAGINATOR -->
<input type="hidden" name="inicioPaginator" value="0">
<input type="hidden" name="cantidadPaginator" value="10">
<input type="hidden" name="pagePaginator" value="1">
<input type="hidden" name="cantidadRegistros" value="<?= $quantity ? $quantity : 10 ?>">
<input type="hidden" name="pagesLimit" value="4">
