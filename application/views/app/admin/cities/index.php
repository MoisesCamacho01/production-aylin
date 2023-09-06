<!-- API DE GOOGLE MAPS -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0Ko6qUa0EFuDWr77BpNJOdxD-QLstjBk&libraries=places,geometry,drawing&callback=initMap" defer>
</script>
<!-- SELECT  -->
<link rel="stylesheet" href="<?= base_url('resources/librerias/select2/dist/css/select2.min.css'); ?>">
<!--  -->
<div class="row">
	<div class="col-md-12">
	<a href="" class="fw">CANTONES /</a>
	<span class="fw">LISTADO</span>

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
	<a class="btn btn-warning text-white btnViewMap" href="#" data-bs-toggle="modal" data-bs-target="#viewMapAlarmModal" zoom="9">
		<b>Visualizar Cantones</b>
	</a>
    </div>
</div><br>


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

<!-- MODAL VISUALIZAR DIBUJO CON ALARMAS -->
<div class="modal fade" id="viewMapAlarmModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel4"> Mapa De Cantones</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div class="loaderModal loader mt-4 ocultar"></div>
						<div id="viewMapAlarm" class="mapa"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="updateModalA" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Actualizar Alarma</h5>
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
								<select id="managerE" class="select-alarm form-select" name="managersE" style="width: 100%">

									<?php if(count($managers)>0): ?>
										<?php foreach ($managers as $row): ?>
											<option value="<?= $row->id?>"><?= $row->name?> <?= $row->last_name?></option>
										<?php endforeach;?>
									<?php endif;?>
								</select>
								<span class="validate-text" name="managerE"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-12 mb-2">
								<label for="NameSector" class="form-label">Sector</label>
								<input type="text" id="NameSector" class="form-control" disabled value="" placeholder="Ingrese un Sector" />
								<input type="hidden" id="sectorE" value="">
								<span class="validate-text" name="sectorE"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-12 mb-2 mt-2">
								<label class="form-label">Ubicación de la alarma</label>
							</div>
							<div class="col-6 mb-2 mt-2">
								<input type="text" id="latitudeE" class="form-control" disabled value="" placeholder="latitude" />
								<span class="validate-text" name="latitudeE"></span>
							</div>
							<div class="col-6 mb-2 mt-2">
								<input type="text" id="longitudeE" class="form-control" disabled value="" placeholder="longitude" />
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
				<!-- Button trigger modal -->
				<button type="button" id="editArea" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#dibujarModalSonoro">
					Editar rango sonoro
				</button>
				<button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#viewMapAlarmModal">
					Cancelar
				</button>
				<button type="button" id="btnUpdateAlarm" class="btn btn-primary">Actualizar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL DIBUJAR -->
<div class="modal fade" id="dibujarModalSonoro" tabindex="-1" aria-hidden="true">
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
						<div id="mapArea" class="mapa ocultar"></div>
						<input type="hidden" name="cords" value="">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info btnNuevo disabled">
					Nuevo dibujo
				</button>
				<button type="button" class="btn btn-info btnMB" data-bs-toggle="modal" data-bs-target="#modalBorrarPolygonA">
					Borrar dibujo
				</button>
				<button type="button" class="btn btn-success btnMover">
					Mover dibujo
				</button>
				<button type="button" class="btn btn-danger btnNoMover disabled">
					No mover dibujo
				</button>
				<button type="button" class="btn btn-outline-secondary btnCloseModal" data-bs-target="#updateModalA" data-bs-toggle="modal">
					Cancelar
				</button>
				<button type="button" id="btnSaveDrawA" data-bs-toggle="modal" data-bs-target="#updateModalA" class="btn btn-primary">Guardar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL START SOUND -->
<div class="modal fade" id="soundAlarmModel" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Activar alarma</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label class="form-label">¿Seguro quieres activar la alarma?</label>
						<span class="validate-text" name="sound"></span>
						<span class="validate-text" name="ip"></span>
					</div>
				</div>

				<div class="row">
					<div class="col-12 mb-2">
						<label for="typeNot" class="form-label">Tipo de notificación</label>
                  <select id="typeNot" class="form-select">
                     <option value="" selected>Seleccione un opción</option>
							<?php if(count($buttonNotifications)>0): ?>
								<?php foreach ($buttonNotifications as $row): ?>
									<option value="<?= $row->id?>"><?= $row->name?></option>
								<?php endforeach;?>
							<?php endif;?>
                  </select>
						<span class="validate-text" name="typeNot"></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="why" class="form-label">¿Por que la activo?</label>
						<input type="text" id="why" class="form-control" placeholder="Motivo" />
						<span class="validate-text" name="why"></span>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Cancelar
				</button>
				<button type="button" id="btnActiveAlarm" class="btn btn-primary">Activar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL STOP SOUND -->
<div class="modal fade" id="stopSoundAlarmModel" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Parar alarma</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label class="form-label">¿Seguro quieres para la alarma?</label>
						<span class="validate-text" name="sound2"></span>
						<span class="validate-text" name="typeNot2"></span>
						<span class="validate-text" name="ip2"></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="why2" class="form-label">¿Por que la paraste?</label>
						<input type="text" id="why2" class="form-control" placeholder="Motivo" />
						<span class="validate-text" name="why2"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Cancelar
				</button>
				<button type="button" id="btnStopAlarm" class="btn btn-primary">Parar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL PARA ASEGURAR BORRAR-->
<div class="modal fade" id="modalBorrarPolygonA" tabindex="-1" aria-hidden="true">
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
				<button type="button" class="btn btn-outline-secondary" data-bs-target="#dibujarModalSonoro" data-bs-toggle="modal">
					Cancelar
				</button>
				<button type="button" data-bs-target="#dibujarModalSonoro" data-bs-toggle="modal" class="btn btn-primary btnBorrar">Aceptar</button>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="idInstitution" value="12">
<!-- PAGINATOR -->
<input type="hidden" name="inicioPaginator" value="0">
<input type="hidden" name="cantidadPaginator" value="10">
<input type="hidden" name="pagePaginator" value="1">
<input type="hidden" name="cantidadRegistros" value="<?= $quantity ? $quantity : 10 ?>">
<input type="hidden" name="pagesLimit" value="4">

<!-- ALARMA -->
<input type="hidden" name="codeUser" id="codeUser" value="<?= $code ?>">
<input type="hidden" name="typeNotVal" id="typeNotVal" value="">
<input type="hidden" name="userName" id="userName" value="<?= $userName ?>">
<input type="hidden" id="sound" active="false" value="">
<input type="hidden" id="soundName" name="nameSectorSound" value="">
<input type="hidden" name="msm" value="">
<input type="hidden" name="ipUser" id="ip" value="">
<input type="hidden" id="lat" name="lat" value="">
<input type="hidden" id="lng" name="lng" value="">
<input type="hidden" name="urlMap" value="<?= site_url() ?>">

<!-- RUTAS -->
<input type="hidden" name="ruta1" value="drawState">
<input type="hidden" name="ruta2" value="reports/cities/all-city-state">
<input type="hidden" name="ruta3" value="reports/cities/all-alarm-state">

