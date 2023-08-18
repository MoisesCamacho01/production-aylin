<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
	data-template="vertical-menu-template-free">

<head>
	<meta charset="utf-8" />
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

	<title>Error - 404</title>

	<meta name="description" content="" />

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="<?= base_url('resources/src/img/logo-white.png') ?>" />

	<!-- Icons. Uncomment required icon fonts -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/fonts/boxicons.css')?>" />

	<!-- Core CSS -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/css/core.css') ?>" class="template-customizer-core-css" />
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/css/demo.css') ?>" />

	<!-- Vendors CSS -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />
	<!-- Page -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/css/pages/page-misc.css') ?>" />
	<!-- Helpers -->
	<script src="<?= base_url('resources/layout/assets/vendor/js/helpers.js') ?>"></script>
	<script src="<?= base_url('resources/layout/assets/js/config.js') ?>"></script>
</head>

<body>
	<!-- Content -->

	<!-- Error -->
	<div class="container-xxl container-p-y">
		<div class="misc-wrapper">
			<h2 class="mb-2 mx-2">Pagina no encontrada :(</h2>
			<p class="mb-4 mx-2">Oops! 😖 La URL solicitada no se ha encontrado en este servidor.</p>
			<a href="<?= site_url('login')?>" class="btn btn-primary">Regresar</a>
			<div class="mt-3">
				<img src="<?= base_url('resources/layout/assets/img/illustrations/page-misc-error-light.png')?>" alt="page-misc-error-light" width="500" class="img-fluid"/>
			</div>
		</div>
	</div>
	<!-- /Error -->

	<!-- Core JS -->
	<!-- build:js assets/vendor/js/core.js -->
	<script src="<?= base_url('resources/layout/assets/vendor/libs/jquery/jquery.js') ?>"></script>
	<script src="<?= base_url('resources/layout/assets/vendor/libs/popper/popper.js') ?>"></script>
	<script src="<?= base_url('resources/layout/assets/vendor/js/bootstrap.js') ?>"></script>
	<script src="<?= base_url('resources/layout/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

	<script src="<?= base_url('resources/layout/assets/vendor/js/menu.js') ?>"></script>
	<script src="<?= base_url('resources/layout/assets/js/main.js') ?>"></script>
</body>

</html>
