<!-- Forgot Password -->
<div class="card">
	<div class="card-body">
		<!-- Logo -->
		<div class="app-brand justify-content-center">
			<a href="index.html" class="app-brand-link gap-2">
				<span class="app-brand-text demo text-body fw-bolder text-center mayus">Cambiar contraseña</span>
			</a>
		</div>
		<!-- /Logo -->
		<div id="loader" class="loader ocultar"></div>
		<p id="titleSend" class="mb-4 text-center">Ingresa tu email y tu nueva contraseña</p>
		<form id="formEmail" class="mb-3 visible" method="POST">
			<div class="mb-3">
				<label for="email" class="form-label">E-mail</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu e-mail" autofocus />
				<span class="validate-text" name="email"></span>
			</div>

			<div class="mb-3">
				<label for="password" class="form-label">Contraseña</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" autofocus />
				<span class="validate-text" name="password"></span>
			</div>

			<div class="mb-3">
				<label for="password2" class="form-label">Validar contraseña</label>
				<input type="password" class="form-control" id="password2" name="password" placeholder="Ingresa nuevamente la contraseña" autofocus />
				<span class="validate-text" name="password2"></span>
			</div>
			<button type="button" id="forgotPassword" class="btn btn-primary d-grid w-100">Verificar</button>
		</form>

		<p id="successEmail" class="ocultar text-black fw text-center">Tu contraseña se ha actualizado con éxito</p>
		<p id="erroEmail" class="validate-text ocultar text-black fw">Parece que ocurrió un problema con tu correo electrónico</p>
		<div class="text-center">
			<a href="<?= site_url('login')?>" class="d-flex align-items-center justify-content-center text-primary">
				<i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
				Regresar al Inicio de sesión
			</a>
		</div>
	</div>
</div>
<!-- /Forgot Password -->

<input type="hidden" id="token" value="<?=$token?>">
<span class="validate-text" name="token" style="display:none;"></span>

