<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="<?= base_url('resources/src/img/logo-white.png?t=4') ?>" />

	<!-- Icons. Uncomment required icon fonts -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/fonts/boxicons.css') ?>" />

	<!-- Core CSS -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/css/core.css') ?>" class="template-customizer-core-css" />
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/css/demo.css') ?>" />

	<!-- Vendors CSS -->


	<!-- Page CSS -->
	<!-- Page -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/css/pages/page-auth.css') ?>" />

	<!-- CSS PERSONAL -->
	<link rel="stylesheet" href="<?= base_url('resources/src/css/basic.css') ?>" />

	<!-- Helpers -->
	<script src="<?= base_url('resources/layout/assets/vendor/js/helpers.js') ?>"></script>

	<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	<script src="<?= base_url('resources/layout/assets/js/config.js') ?>"></script>

	<title><?= isset($title) ? $title : 'Nueva Pagina' ?></title>
</head>

<body class="scroll">
	<header>

	</header>
	<input type="hidden" name='url' value="<?=site_url()?>">
	<input type="hidden" name='baseUrl' value="<?=base_url('resources')?>">
	<input type="hidden" name="id" value="">
	<!-- Toast with Placements -->
	<div class="bs-toast toast toast-placement-ex m-2" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
		<div class="toast-header">
			<i class="bx bx-bell me-2"></i>
			<div class="me-auto fw-semibold toastTitle">Bootstrap</div>
			<small class="toastTime">11 mins ago</small>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">Fruitcake chocolate bar tootsie roll gummies gummies jelly beans cake.</div>
	</div>
	<!-- Toast with Placements -->
	<main>
		<div class="layout-wrapper layout-content-navbar">
			<div class="layout-container">
				<?= $sidbar ? $sidbar : ''?>
				<div class="layout-page">
					<?= $nav ? $nav : ''?>
					<!-- Content wrapper -->
					<div class="content-wrapper">
						<div class="container-xxl flex-grow-1 container-p-y">
							<?= $page ? $page : ''?>
						</div>

						<?= $footer ? $footer: ''?>
						<div class="content-backdrop fade"></div>
					</div>
				</div>
			</div>
			<!-- Overlay -->
			<div class="layout-overlay layout-menu-toggle"></div>
		</div>
	</main>
	<footer>

	</footer>

	<!-- Core JS -->
	<!-- build:js assets/vendor/js/core.js -->
	<script src="<?= base_url('resources/layout/assets/vendor/libs/jquery/jquery.js') ?>"></script>
	<!-- <script src="<?= base_url('resources/layout/assets/vendor/libs/popper/popper2.js') ?>"></script> -->
	<!-- <script src="<?= base_url('resources/layout/assets/vendor/js/bootstrap2.js') ?>"></script> -->

	<script src="<?= base_url('resources/src/jquery.js') ?>"></script>
	<script src="<?= base_url('resources/src/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?= base_url('resources/layout/assets/vendor/js/menu.js') ?>"></script>
	<!-- endbuild -->

	<!-- Vendors JS -->

	<!-- Main JS -->
	<script src="<?= base_url('resources/layout/assets/js/main.js') ?>"></script>
	<script src="<?= base_url('resources/shared/htmlDecode.js');?>"></script>
	<script src="<?= base_url('resources/shared/search.js?t=4');?>"></script>
	<script src="<?= base_url('resources/shared/buttons.js?t=5');?>"></script>

	<!-- Page JS -->
	<script src="<?= base_url('resources/layout/assets/js/ui-toasts.js') ?>"></script>

	<!-- my-validate -->
	<script src="<?= base_url('resources/librerias/my-validate/validate.js?t=4') ?>"></script>
	<script src="<?= base_url('resources/src/js/close.js?t=4')?>"></script>

	<!-- Place this tag in your head or just before your close body tag. -->
	<!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->

	<!-- WEBSOCKET -->
	<!-- <script src="http://localhost:8080/socket.io/socket.io.js"></script> -->
	<script src="https://alarm-socketio.up.railway.app/socket.io/socket.io.js"></script>
	<script src="<?= base_url('resources/shared/websocket.js?t=2')?>"></script>

	<script type="text/javascript">
		function base_url(recurso = "") {
			return "<?= base_url() ?>" + recurso;
		}
	</script>

	<?php foreach ($js as $row) : ?>
		<script type="text/javascript" src="<?= base_url($row) ?>"></script>
	<?php endforeach; ?>

	<?php if (!empty($alert)) : ?>
		<?php if (gettype($alert) === 'object') : ?>
			<script type="text/javascript">
				// Swal.fire()
			</script>
	<?php endif;
	endif; ?>



</body>

</html>
