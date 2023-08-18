</div>
</div>
</div>
</main>
<footer>
	<span>Desarrollado por la facultad de <a href="https://ciya.utc.edu.ec/" class="mayus">Ciencias de la ingeniería y aplicadas</a></span>
</footer>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="<?= base_url('resources/layout/assets/vendor/libs/jquery/jquery.js') ?>"></script>
<script src="<?= base_url('resources/layout/assets/vendor/libs/popper/popper.js') ?>"></script>
<script src="<?= base_url('resources/layout/assets/vendor/js/bootstrap.js') ?>"></script>
<script src="<?= base_url('resources/layout/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

<script src="<?= base_url('resources/layout/assets/vendor/js/menu.js') ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="<?= base_url('resources/layout/assets/js/main.js') ?>"></script>

<!-- Page JS -->
<script src="<?= base_url('resources/layout/assets/js/ui-toasts.js') ?>"></script>

<!-- my-validate -->
<script src="<?= base_url('resources/librerias/my-validate/validate.js') ?>"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script type="text/javascript">
	function base_url(recurso = ""){
		return "<?= base_url() ?>"+recurso;
	}
</script>

<?php foreach ($js as $row): ?>
	<script type="text/javascript" src="<?= base_url($row)?>"></script>
<?php endforeach;?>

<?php if(!empty($alert)): ?>
	<?php if(gettype($alert) === 'object'):?>
	<script type="text/javascript">
		// Swal.fire()
	</script>
<?php endif; endif;?>



</body>

</html>
