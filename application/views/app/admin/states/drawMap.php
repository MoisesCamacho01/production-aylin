<h4 class="fw-bold py-3 mb-4">
	<span class="text-muted fw-light" id="backButton">Provincias /</span> Listado
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-12">
				<h5>Dibujar el area de la provincia</h5>
			</div>
			<div class="col-12">
				<div class="dropdown">
					<button class="btn btn-white border border-1 dropdown-toggle" type="button" data-bs-toggle="dropdown"
						aria-expanded="false">
						Seleccionar una provincia
					</button>
					<?php if(count($states)>0):?>
						<ul class="dropdown-menu">
						<?php foreach($states as $row):?>
							<li><a class="dropdown-item drawStateButton" href="#" dataId="<?=$row->id?>"><?= $row->name?></a></li>
						<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item drawStateButton" href="#">No existen provincias</a></li>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<!-- <div id="loader" class="loader mt-4"></div> -->
	<div class="card-body">
		<div id="viewMap" class="mapa"></div>
	</div>
</div>
<!--/ Basic Bootstrap Table -->
