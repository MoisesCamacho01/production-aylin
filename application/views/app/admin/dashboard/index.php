<div class="row">
	<div class="col-lg-6 col-12 mb-4">
		<div class="card">
			<div class="d-flex align-items-end row">
				<div class="col-sm-7">
					<div class="card-body">
						<h5 class="card-title text-primary">Bienvenido
							<?= $dataUser->user_name ?> 🎉
						</h5>
						<p class="mb-4">
							Un gusto tenerte de vuelta.
						</p>
					</div>
				</div>
				<div class="col-sm-5 text-center text-sm-left">
					<div class="card-body pb-0 px-0 px-md-4">
						<img src="<?= base_url('resources/layout/assets/img/illustrations/man-with-laptop-light.png') ?>"
							height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
							data-app-light-img="illustrations/man-with-laptop-light.png" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--/ Total Revenue -->
	<div class="col-lg-2 col-12 mb-4">
		<div class="card bg-danger">
			<div class="card-body text-center">
				<span class="fw d-block text-white mayus">Parroquias</span>
				<h3 class="card-title text-nowrap text-white">
					<?= $parishes ?>
				</h3>
				<div class="card-title d-flex align-items-center justify-content-center hover-my">
					<div class="avatar flex-shrink-0">
						<a href="<?= base_url('pdf-parishes/0') ?>" target="_blank">
							<i class='bx bxs-download text-white h2'></i>
						</a>
					</div>
					<a href="<?= base_url('pdf-parishes/0') ?>" target="_blank">
						<span class="mayus text-white fw">Descargar</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-2 col-12 mb-4">
		<div class="card bg-success">
			<div class="card-body text-center">

				<span class="fw d-block text-white mayus">Barrios</span>
				<h3 class="card-title text-nowrap text-white">
					<?= $sectors ?>
				</h3>

				<div class="card-title d-flex align-items-center justify-content-center hover-my">
					<div class="avatar flex-shrink-0">
						<a href="<?= base_url('pdf-sectors/0'); ?>" target="_blank">
							<i class='bx bxs-download text-white h2'></i>
						</a>
					</div>
					<a href="<?= base_url('pdf-sectors/0'); ?>" target="_blank">
						<span class="mayus text-white fw">Descargar</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-2 col-12 mb-4">
		<div class="card bg-info">
			<div class="card-body text-center">
				<span class="fw d-block text-white mayus">Alarmas</span>
				<h3 class="card-title text-white">
					<?= $alarms ?>
				</h3>
				<div class="card-title d-flex align-items-center justify-content-center hover-my">
					<div class="avatar flex-shrink-0">
						<a href="<?= base_url('pdf-alarms/0') ?>" target="_blank" rel="noopener noreferrer">
							<i class='bx bxs-download text-white h2'></i>
						</a>
					</div>
					<a href="<?= base_url('pdf-alarms/0') ?>" target="_blank" rel="noopener noreferrer">
						<span class="mayus text-white fw">Descargar</span>
					</a>
				</div>
			</div>
		</div>
	</div>


</div>

<div class="row">
	<div class="col-lg-6 col-12 mb-4">
		<div class="card text-center bg-warning">
			<div class="card-body">
				<span class="fw d-block mb-1 mayus text-white">Usuarios administrativos</span>
				<h3 class="card-title mb-2 text-white">
					<?= $users ?>
				</h3>
				<div class="card-title d-flex align-items-center justify-content-center hover-my">
					<div class="avatar flex-shrink-0">
						<a href="<?= base_url('pdf-users/web'); ?>" target="_blank">
							<i class='bx bxs-download text-success h2 text-white'></i>
						</a>
					</div>
					<a href="<?= base_url('pdf-users/web'); ?>" target="_blank">
						<span class="mayus text-white fw">Descargar</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-6 col-12 mb-4">
		<div class="card text-center bg-primary">
			<div class="card-body">
				<span class="fw d-block mb-1 mayus text-white">Usuarios del app</span>
				<h3 class="card-title mb-2 text-white">
					<?= $usersMovil ?>
				</h3>
				<div class="card-title d-flex align-items-center justify-content-center hover-my">
					<div class="avatar flex-shrink-0">
						<a href="<?= base_url('pdf-users/movil'); ?>" target="_blank">
							<i class='bx bxs-download text-success h2 text-white'></i>
						</a>
					</div>
					<a href="<?= base_url('pdf-users/movil'); ?>" target="_blank">
						<span class="mayus text-white fw">Descargar</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<!-- Order Statistics -->
	<div class="col-md-12 col-lg-6 mb-4">
		<div class="card h-100">
			<div class="card-header d-flex align-items-center justify-content-between pb-0">
				<div class="card-title mb-0">
					<h5 class="m-0 me-2">Estado de las alarmas</h5>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<div class="d-flex flex-column align-items-center gap-1">
						<h2 class="mb-2">
							<?= $alarms ?>
						</h2>
						<span>Total de alarmas</span>
					</div>
					<div id="orderStatisticsChart"></div>
				</div>
				<ul class="p-0 m-0">
					<li class="d-flex mb-4 pb-1">
						<div class="avatar flex-shrink-0 me-3">
							<span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
						</div>
						<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
							<div class="me-2">
								<h6 class="mb-0">Activas</h6>
							</div>
							<div class="user-progress">
								<small class="fw-semibold">
									<?= $alarmsActive ?>
								</small>
							</div>
						</div>
					</li>
					<li class="d-flex mb-4 pb-1">
						<div class="avatar flex-shrink-0 me-3">
							<span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
						</div>
						<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
							<div class="me-2">
								<h6 class="mb-0">Suspendidas</h6>
							</div>
							<div class="user-progress">
								<small class="fw-semibold">
									<?= $alarmsSuspend ?>
								</small>
							</div>
						</div>
					</li>

				</ul>
			</div>
		</div>
	</div>
	<!--/ Order Statistics -->
	<!-- Transactions -->
	<div class="col-md-12 col-lg-6 mb-4">
		<div class="card h-100">
			<div class="card-header d-flex align-items-center justify-content-between">
				<h5 class="card-title m-0 me-2">Historial de notificaciones</h5>
			</div>
			<div class="card-body">
				<ul class="p-0 m-0">

					<?php if ($historyNotifications):
						$i = 0; ?>
						<?php foreach ($historyNotifications as $row):
							$i = $i + 1;
							if ($i <= 5):
								?>
								<li class="d-flex mb-4 pb-1">
									<div class="avatar flex-shrink-0 me-3">
										<img src="<?= base_url('resources/layout/assets/img/icons/unicons/chart.png') ?>" alt="User"
											class="rounded" />
									</div>
									<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
										<div class="me-2">
											<small class="text-muted d-block mb-1">Notificación</small>
											<h6 class="mb-0">
												<?= $row->type ?>
											</h6>
										</div>
										<div class="user-progress d-flex align-items-center gap-1">
											<h6 class="mb-0">
												<?= $row->user_name ?> <br> <span>
													<?= $row->created_at ?>
												</span>
											</h6>
										</div>
									</div>
								</li>
							<?php endif; endforeach; ?>
					<?php endif; ?>

				</ul>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<!-- Total Revenue -->
	<div class="col-12 mb-4">
		<div class="card bg-dark">
			<div class="row row-bordered g-0">
				<div class="col-md-12">
					<h5 class="card-header m-0 me-2 pb-3 text-white">Activación de alarmas comunitarias por motivo</h5>
					<div id="totalRevenueChart" class="px-2"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<!--/ Transactions -->
	<!-- Expense Overview -->
	<div class="col-md-12 col-lg-12 mb-4">
		<div class="card h-100">
			<div class="card-header d-flex align-items-center justify-content-between">
				<ul class="nav nav-pills" role="tablist">
					<li>
						<h5>Seguimiento de activación de alarmas
							- Grafica:
							<span id="textKp8">
								TODOS
							</span>
						</h5>
					</li>
				</ul>
				<div class="dropdown">
					<button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false">
						<i class="bx bx-dots-vertical-rounded"></i>
					</button>
					<div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
						<?php if (count($typesNotification) > 0): ?>
							<a class="dropdown-item btnKPI8" data="todos">TODOS</a>
							<?php foreach ($typesNotification as $row): ?>
								<a class="dropdown-item btnKPI8" data="<?= $row->name ?>"><?= $row->name ?></a>
							<?php endforeach; endif; ?>
					</div>
				</div>
			</div>
			<div class="card-body px-0">
				<div class="tab-content p-0">
					<div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
						<div id="incomeChart"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--/ Expense Overview -->
	<!-- SEGUIMIENTO DE ACTIVACION LINEAS -->
	<div class="col-md-12 order-3 mb-4">
		<div class="card">
			<div class="card-header header-elements">
				<div>
					<h5 class="card-title mb-0">Comparativa de activación de alarmas comunitarias por motivo</h5>
				</div>
				<div class="card-header-elements ms-auto py-0">
					<h5 class="mb-0 me-3"><b>TOTAL DE ALARMAS:</b>
						<?= $alarms ?>
					</h5>
				</div>
			</div>
			<div class="card-body pt-2">
				<canvas id="comparationMotivos" class="chartjs" height="500"></canvas>
			</div>
		</div>
	</div>
	<!--  -->
</div>

<!-- HIDDENS STADISTICS-->
<input type="hidden" name="alarmsActive" value="<?= $alarmsActive ?>">
<input type="hidden" name="alarmsSuspend" value="<?= $alarmsSuspend ?>">
<input type="hidden" name="totalMotiveAlarm" value='<?= $totalMotiveAlarm ?>'>
<input type="hidden" name="seguimiento" value='<?= $seguimientoActivacionAlarmas ?>'>
<input type="hidden" name="comparativa" value='<?= $comparativaNotificacionAlarmas ?>'>
