<h4 class="fw-bold py-3 mb-4">Activación de alarmas
	<?php foreach ($buttonTop as $row): ?>
		<?php if ($row->id == 'BP0010'): ?>
			<a class="btn btn-info text-white" target="_blank" href="<?= site_url('pdf-active-alarm') ?>">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
		<?php if ($row->id == 'BP0011'): ?>
			<a class="btn btn-danger text-white" href="<?= site_url('excel-active-alarm') ?>">
				<?= $row->name ?>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</h4>
<!-- Basic Bootstrap Table -->
<div class="card">
	<h5 class="card-header">Historial de activación de alarmas</h5>
	<div class="table-responsive text-nowrap">
		<table class="table">
			<thead>
				<tr>
					<th>N</th>
					<th>IP</th>
					<th>Email</th>
					<th>Nombre</th>
					<th>Sector</th>
					<th>Motivo de activación</th>
					<th>Fecha de activación</th>
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

				<?php for ($i = 1; $i <= round(($quantity + 1) / 6); $i++): ?>
					<li class="page-item <?= $i == 1 ? 'active' : ''; ?>">
						<a class="page-link btnPages" href="#">
							<?= $i ?>
						</a>
					</li>
				<?php endfor; ?>

				<li class="page-item">
					<a class="page-link page-right" href="#"><i class='bx bxs-right-arrow'></i></a>
				</li>
			</ul>
		</nav>
	</div>
</div>
<!--/ Basic Bootstrap Table -->

<!-- PAGINATOR -->
<input type="hidden" name="inicioPaginator" value="0">
<input type="hidden" name="cantidadPaginator" value="10">
<input type="hidden" name="pagePaginator" value="1">
<input type="hidden" name="cantidadRegistros" value="<?= $quantity ? $quantity : 10 ?>">
<input type="hidden" name="pagesLimit" value="4">
