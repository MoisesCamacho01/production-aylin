<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="<?= base_url('resources/src/img/logo-white.png') ?>" />

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

	<!-- Icons. Uncomment required icon fonts -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/fonts/boxicons.css') ?>" />

	<!-- Core CSS -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/css/core.css') ?>" class="template-customizer-core-css" />
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/css/demo.css') ?>" />

	<!-- Vendors CSS -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

	<!-- Page CSS -->
	<!-- Page -->
	<link rel="stylesheet" href="<?= base_url('resources/layout/assets/vendor/css/pages/page-auth.css') ?>" />

	<!-- CSS PERSONAL -->
	<link rel="stylesheet" href="<?= base_url('resources/src/css/basic.css?t=4') ?>" />
	<link rel="stylesheet" href="<?= base_url('resources/src/css/login.css') ?>" />

	<!-- Helpers -->
	<script src="<?= base_url('resources/layout/assets/vendor/js/helpers.js') ?>"></script>

	<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	<script src="<?= base_url('resources/layout/assets/js/config.js') ?>"></script>

	<title><?= isset($title) ? $title : 'Nueva Pagina' ?></title>
</head>

<body class="background-img">
	<header>

	</header>
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
		<div class="container-xxl">
			<div class="authentication-wrapper authentication-basic container-p-y">
				<div class="authentication-inner">
