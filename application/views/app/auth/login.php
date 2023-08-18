<!-- Login -->
<div class="card">
	<div class="card-body">
		<!-- Logo -->
		<div class="app-brand justify-content-center">
			<a href="#" class="app-brand-link gap-1 pointer-no">
				<span class="app-brand-logo demo">
					<!-- IMAGEN -->
				</span>
				<span class="app-brand-text demo text-body fw-bolder text-center mayus">UNIVERSIDAD TÉCNICA <br> DE COTOPAXI</span>
			</a>
		</div>
		<!-- /Logo -->
		<span class="validate-text text-center" name="ip"></span>
		<h4 class="mb-2 text-center">Bienvenido! 😉</h4>
		<p class="mb-4">Entra a tu cuenta y comienza con esta aventura</p>

		<form id="formAuthentication" class="mb-3" method="POST">
			<div class="mb-3">
				<label for="email" class="form-label">Email o Usuario</label>
				<input type="text" class="form-control" id="email" name="email" placeholder="Ingresa tu email o tu usuario" autofocus />
				<span class="validate-text" name='email'></span>
			</div>
			<div class="mb-3 form-password-toggle">
				<div class="d-flex justify-content-between">
					<label class="form-label" for="password">Contraseña</label>
					<a href="<?= site_url('recuperar-password')?>">
						<small>Olvide mi contraseña</small>
					</a>
				</div>
				<div class="input-group input-group-merge">
					<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
					<input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
				</div>
				<div class="mb-3">
					<span class="validate-text" name='password'></span>
				</div>
			</div>
			<!-- <div class="mb-3">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" id="remember-me" />
					<label class="form-check-label" for="remember-me"> Recuerda me </label>
				</div>
			</div> -->
			<div class="mb-3">
				<button class="btn btn-primary d-grid w-100" type="submit" id="btnIngresar">Iniciar Sesión</button>
			</div>
		</form>

		<!-- <p class="text-center">
			<span>New on our platform?</span>
			<a href="auth-register-basic.html">
				<span>Create an account</span>
			</a>
		</p> -->
	</div>
</div>
<!-- /Login -->

<input type="hidden" name="ipUser" id="ip" value="">
