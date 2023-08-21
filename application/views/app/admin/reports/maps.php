<!-- API DE GOOGLE MAPS -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0Ko6qUa0EFuDWr77BpNJOdxD-QLstjBk&libraries=places&callback=initMap" defer>
</script>
<!--  -->

<h4 class="fw-bold py-3 mb-4">
	<span class="text-muted fw-light">MAPAS</span>
	<a class="btn btn-success text-white ms-3" data-bs-toggle="modal" data-bs-target="#viewSector">
		FILTROS
	</a>
	<a class="btn btn-info text-white" id="btnViewAll">
		TRAER TODOS
	</a>
	<a href="#" onclick="javascript:window.print()" class="btn btn-warning text-white mayus">
		Imprimir mapa
	</a>

</h4>

<div class="card" id="imprMapa">
	<div class="row">
		<div class="col-12">
			<h5 class="card-header" id="title-map">Descripción de mapa</h5>
		</div>
		<div class="col-3 ps-5 mb-4" style="font-size:18px;">
			<div style="width: 20px; height: 20px; border-radius:50%; background-color: #1051D5; float: left; margin-top: 5px; margin-right:10px;"></div> Alarmas
		</div>
		<div class="col-3 ps-5 mb-4" style="font-size:18px;">
			<div style="width: 20px; height: 20px; border-radius:50%; background-color: #B22222; float: left; margin-top: 5px; margin-right:10px;"></div> Provincia
		</div>
		<div class="col-3 ps-5 mb-4" style="font-size:18px;">
			<div style="width: 20px; height: 20px; border-radius:50%; background-color: #FF7F50; float: left; margin-top: 5px; margin-right:10px;"></div> Cantón
		</div>
		<div class="col-3 ps-5 mb-4" style="font-size:18px;">
			<div style="width: 20px; height: 20px; border-radius:50%; background-color: #8C4966; float: left; margin-top: 5px; margin-right:10px;"></div> Parroquia
		</div>
	</div>
	<div id="bodyTable">
		<div id="viewMap" class="" style="border: none; width: 100%; height: 70vh;"></div>
	</div>
</div>

<!-- MODALES -->
<div class="modal fade" id="viewSector" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">FILTROS</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-12 mb-2">
						<label for="states" class="form-label">Provincias</label>
                  <select id="states" class="form-select">
                     <option value="" selected>Selecciona un provincia</option>
							<?php if(count($states)>0): ?>
								<?php foreach ($states as $row): ?>
									<option value="<?= $row->id?>"><?= $row->name?></option>
								<?php endforeach;?>
							<?php endif;?>
                  </select>
						<span class="validate-text" name="states"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="cities" class="form-label">Cities</label>
                  <select id="cities" class="form-select">
                     <option value="" selected>Seleccione un Cities</option>
                  </select>
						<span class="validate-text" name="cities"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="parishes" class="form-label">Parroquias</label>
                  <select id="parishes" class="form-select">
                     <option value="" selected>Seleccione un parroquia</option>

                  </select>
						<span class="validate-text" name="parishes"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="sectors" class="form-label">Barrio</label>
                  <select id="sectors" class="form-select">
                     <option value="" selected>Seleccione un barrio</option>

                  </select>
						<span class="validate-text" name="sectors"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Cancelar
				</button>
				<button type="button" id="btnViewSector" class="btn btn-primary" data-bs-dismiss="modal">Ver</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
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
								<select id="managerE" class="form-select">
									<option value="" selected>Selecciona un Encargado</option>
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
								<label for="NameCiudad" class="form-label">Sector</label>
								<input type="text" id="NameSector" class="form-control" disabled value="" placeholder="Ingrese un Sector" />
								<input type="hidden" id="sectorE" value="">
								<span class="validate-text" name="sectorE"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-12 mb-2 mt-2">
								<label for="mapLocationAlarmE" class="form-label">Ubicación de la alarma</label>
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
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Close
				</button>
				<button type="button" id="btnUpdate" class="btn btn-primary">Actualizar</button>
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
						<label for="usernameE" class="form-label">¿Seguro quieres activar la alarma?</label>
						<span class="validate-text" name="sound"></span>
						<span class="validate-text" name="ip"></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="why" class="form-label">¿Por que la activo?</label>
						<input type="text" id="why" class="form-control" placeholder="Nombre de la extensión" />
						<span class="validate-text" name="why"></span>
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
						<label for="usernameE" class="form-label">¿Seguro quieres para la alarma?</label>
						<span class="validate-text" name="sound"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Cancelar
				</button>
				<button type="button" id="btnPararAlarm" data-bs-dismiss="modal" class="btn btn-primary">Activar</button>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="codeUser" id="codeUser" value="<?= $code ?>">
<input type="hidden" name="typeNotVal" id="typeNotVal" value="">
<input type="hidden" name="userName" id="userName" value="<?= $userName ?>">

<input type="hidden" name="ipUser" id="ip" value="">
<input type="hidden" id="sound" active="false" name="idSectorSound" value="">
<input type="hidden" name="idInstitution" value="">

<input type="hidden" name="urlMap" value="<?= site_url() ?>">

