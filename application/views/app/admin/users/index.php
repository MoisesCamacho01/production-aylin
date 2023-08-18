<h4 class="fw-bold py-3 mb-4">
	<span class="text-muted fw-light">Usuarios /</span> Listado
	<?php foreach ($buttonTop as $row): ?>
		<?php if($row->id == 'BP001') : ?>
			<a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createModal">
				<?= $row->name?>
			</a>
		<?php endif; ?>
		<?php if($row->id == 'BP0010') : ?>
			<a class="btn btn-info text-white" target="_blank" href="<?= site_url('pdf-users') ?>">
				<?= $row->name?>
			</a>
		<?php endif; ?>
		<?php if($row->id == 'BP0011') : ?>
			<a class="btn btn-danger text-white" href="<?= site_url('excel-users') ?>">
				<?= $row->name?>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</h4>
<!-- Basic Bootstrap Table -->
<div class="card">
	<h5 class="card-header">Usuarios</h5>
	<div class="table-responsive text-nowrap">
		<table class="table">
			<thead>
				<tr>
					<th>N</th>
					<th>Usuario</th>
					<th>Email</th>
					<th>Tipo de Usuarios</th>
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
				<h5 class="modal-title" id="exampleModalLabel1">Nuevo Usuario</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="username" class="form-label">Nombre de usuario</label>
						<input type="text" id="username" class="form-control" placeholder="Nombre Usuario" />
						<span class="validate-text" name='username'></span>
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="email" class="form-label">Email</label>
						<input type="text" id="email" class="form-control" placeholder="xxxx@xxx.xx" />
						<span class="validate-text" name='email'></span>
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="password" class="form-label">Contraseña</label>
						<input type="password" id="password" class="form-control" placeholder="*******" />
						<span class="validate-text" name='password'></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="userType" class="form-label">Tipo de usuario</label>
						<select id="userType" class="form-select">
							<option value="" selected>Selecciona un tipo de usuario</option>
							<?php if (count($userTypes) > 0) : ?>
								<?php foreach ($userTypes as $row) : ?>
									<option value="<?= $row->id ?>"><?= $row->name ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<span class="validate-text" name='userType'></span>
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
				<h5 class="modal-title" id="exampleModalLabel1">Actualizar Usuario</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="usernameE" class="form-label">Nombre de usuario</label>
						<input type="text" id="usernameE" class="form-control" placeholder="Nombre Usuario" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="emailE" class="form-label">Email</label>
						<input type="email" id="emailE" class="form-control" placeholder="xxxx@xxx.xx" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="passwordE" class="form-label">Contraseña</label>
						<input type="password" id="passwordE" class="form-control" placeholder="*******" />
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="userTypeE" class="form-label">Tipo de usuario</label>
						<select id="userTypeE" class="form-select">
							<option selected>Selecciona un tipo de usuario</option>
							<?php if (count($userTypes) > 0) : ?>
								<?php foreach ($userTypes as $row) : ?>
									<option value="<?= $row->id ?>"><?= $row->name ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
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
				<h5 class="modal-title" id="exampleModalLabel1">Eliminar Usuario</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="usernameE" class="form-label">¿Seguro quieres eliminar el usuario?</label>
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
				<h5 class="modal-title" id="exampleModalLabel1">Suspender Usuario</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="usernameE" class="form-label">¿Seguro quieres suspender el usuario?</label>
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
				<h5 class="modal-title" id="exampleModalLabel1">Activar Usuario</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="usernameE" class="form-label">¿Seguro quieres activar este usuario?</label>
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

<!-- MODAL PROFILE -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">Perfil de usuario</h5>
				<button type="button" class="btn-close btn-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="name" class="form-label">Nombre</label>
						<input type="text" id="name" class="form-control" placeholder="Ingrese los Nombres" />
						<span class="validate-text" name='name'></span>
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="lastName" class="form-label">Apellido</label>
						<input type="text" id="lastName" class="form-control" placeholder="Ingrese los Apellidos" />
						<span class="validate-text" name='lastName'></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="userType" class="form-label">País</label>
						<input type="text" class="form-control" disabled value="<?=$country->name?>" placeholder="Ingrese un país" />
						<input type="hidden" id="country" value="<?=$country->id?>">
						<span class="validate-text" name='country'></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="states" class="form-label">Provincia</label>
						<select id="states" class="form-select">
							<option value="" selected>Selecciona una provincia</option>
							<?php if (count($states) > 0) : ?>
								<?php foreach ($states as $row) : ?>
									<option value="<?= $row->id ?>"><?= $row->name ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<span class="validate-text" name='states'></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="cities" class="form-label">Canton</label>
						<select id="cities" class="form-select">
							<option value="" selected>Selecciona un canton</option>
						</select>
						<span class="validate-text" name='cities'></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-2">
						<label for="documentType" class="form-label">Tipo de documentación</label>
						<select id="documentType" class="form-select">
							<option value="" selected>Selecciona un tipo de documento</option>
							<?php if (count($documentTypes) > 0) : ?>
								<?php foreach ($documentTypes as $row) : ?>
									<option value="<?= $row->id ?>"><?= $row->name ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<span class="validate-text" name='documentType'></span>
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="ci" class="form-label">Número de identificación</label>
						<input type="text" id="ci" class="form-control" placeholder="Ej: 1750987459" pattern="[0-9]{10}(?:-[0-9])?" />
						<span class="validate-text" name="ci"></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="phone" class="form-label">Teléfono de casa</label>
						<input type="tel" id="phone" class="form-control" placeholder="Ej: 252-71-64" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" />
						<span class="validate-text" name="phone"></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="mobile" class="form-label">Teléfono celular</label>
						<input type="tel" id="mobile" class="form-control" placeholder="Ej: 098-795-5996" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" />
						<span class="validate-text" name="mobile"></span>
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="address" class="form-label">Dirección</label>
						<input type="text" id="address" class="form-control" placeholder="Ingrese la dirección" />
						<span class="validate-text" name='address'></span>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Cancelar
				</button>
				<button type="button" id="btnProfile" class="btn btn-primary">Guardar</button>
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
