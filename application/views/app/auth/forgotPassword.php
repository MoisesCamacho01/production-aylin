<!-- Forgot Password -->
<div class="card">
	<div class="card-body">
		<!-- Logo -->
		<div class="app-brand justify-content-center">
			<a href="index.html" class="app-brand-link gap-2">
				<span class="app-brand-logo demo">
					<!-- IMAGEN -->
				</span>
				<span class="app-brand-text demo text-body fw-bolder text-center mayus">Cambiar <br> contraseña</span>
			</a>
		</div>
		<!-- /Logo -->
		<div id="loader" class="loader ocultar"></div>
		<p id="titleSend" class="mb-4">Ingresa tu email y nosotros te indicaremos como recuperar tu contraseña</p>
		<form id="formEmail" class="mb-3 visible" method="POST">
			<div class="mb-3">
				<label for="email" class="form-label">Email</label>
				<input type="text" class="form-control" id="email" name="email" placeholder="Ingresa tu Email" autofocus />
				<span class="validate-text" name="email"></span>
			</div>
			<button type="button" id="forgotPassword" class="btn btn-primary d-grid w-100">Verificar</button>
		</form>

		<p id="successEmail" class="ocultar text-black fw">Se ha enviado un correo electrónico a tu cuenta, por favor revisa tu bandeja de entrada o tu spam</p>
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
