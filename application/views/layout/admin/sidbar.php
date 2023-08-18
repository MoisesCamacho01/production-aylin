<!-- Menu -->

<aside id="layout-menu" class="sticky layout-menu menu-vertical menu bg-menu-theme">
	<div class="app-brand demo sticky bg-white">
		<a href="index.html" class="app-brand-link">
			<span class="app-brand-logo demo">
				<img src="<?= base_url('resources/src/img/logo.svg')?>" width="40" alt="logo">
			</span>
			<span class="app-brand-text demo menu-text fw-bolder ms-2 mayus">AYLIN</span>
		</a>

		<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
			<i class="bx bx-chevron-left bx-sm align-middle"></i>
		</a>
	</div>
	<div class="menu-inner-shadow"></div>
	<ul class="menu-inner py-1">
		<?= $sidebar; ?>
		<li class="menu-header small text-uppercase"><span class="menu-header-text">CUENTA</span></li>
		<li class="menu-item">
			<a href="#" id="btnCerrar" class="menu-link">
				<i class="menu-icon tf-icons bx bxs-user-detail"></i>
				<div data-i18n="Support">SALIR</div>
			</a>
		</li>
	</ul>

</aside>
<!-- / Menu -->
