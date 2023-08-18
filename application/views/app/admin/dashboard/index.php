<div class="row">
	<div class="col-lg-12 mb-12 order-0">
		<div class="card">
			<div class="d-flex align-items-end row">
				<div class="col-sm-7">
					<div class="card-body">
						<h5 class="card-title text-primary">Bienvenido <?= $dataUser->user_name ?> 🎉</h5>
						<p class="mb-4">
							Un gusto tenerte de vuelta.
						</p>
					</div>
				</div>
				<div class="col-sm-5 text-center text-sm-left">
					<div class="card-body pb-0 px-0 px-md-4">
						<img src="<?= base_url('resources/layout/assets/img/illustrations/man-with-laptop-light.png')?>" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-12"><br></div>

	<!-- Total Revenue -->
	<div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
		<div class="card">
			<div class="row row-bordered g-0">
				<div class="col-md-12">
					<h5 class="card-header m-0 me-2 pb-3">Activación de alarmas comunitarias por mes</h5>
					<div id="totalRevenueChart" class="px-2"></div>
				</div>
			</div>
		</div>
	</div>
	<!--/ Total Revenue -->
	<div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
		<div class="row">
			<div class="col-6 mb-4">
				<div class="card">
					<div class="card-body">
						<div class="card-title d-flex align-items-start justify-content-between">
							<div class="avatar flex-shrink-0">
								<img src="<?= base_url('resources/layout/assets/img/icons/unicons/paypal.png'); ?>" alt="Credit Card" class="rounded" />
							</div>

						</div>
						<span class="d-block mb-1">Barrios</span>
						<h3 class="card-title text-nowrap mb-2"><?=$sectors?></h3>
					</div>
				</div>
			</div>

			<div class="col-6 mb-4">
				<div class="card">
					<div class="card-body">
						<div class="card-title d-flex align-items-start justify-content-between">
							<div class="avatar flex-shrink-0">
								<img src="<?= base_url('resources/layout/assets/img/icons/unicons/cc-primary.png') ?>" alt="Credit Card" class="rounded" />
							</div>
						</div>
						<span class="fw-semibold d-block mb-1">Alarmas</span>
						<h3 class="card-title mb-2"><?= $alarms?></h3>
					</div>
				</div>
			</div>

			<div class="col-lg-6 col-md-12 col-6 mb-4">
				<div class="card">
					<div class="card-body">
						<div class="card-title d-flex align-items-start justify-content-between">
							<div class="avatar flex-shrink-0">
								<img src="<?= base_url('resources/layout/assets/img/icons/unicons/chart-success.png');?>" alt="chart success" class="rounded" />
							</div>
						</div>
						<span class="fw-semibold d-block mb-1">Usuarios</span>
						<h3 class="card-title mb-2"><?= $users?></h3>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-12 col-6 mb-4">
				<div class="card">
					<div class="card-body">
						<div class="card-title d-flex align-items-start justify-content-between">
							<div class="avatar flex-shrink-0">
								<img src="<?= base_url('resources/layout/assets/img/icons/unicons/wallet-info.png') ?>" alt="Credit Card" class="rounded" />
							</div>
						</div>
						<span>Parroquias</span>
						<h3 class="card-title text-nowrap mb-1"><?=$parishes?></h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<!-- Order Statistics -->
	<div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
		<div class="card h-100">
			<div class="card-header d-flex align-items-center justify-content-between pb-0">
				<div class="card-title mb-0">
					<h5 class="m-0 me-2">Estado de las alarmas</h5>
				</div>
				<div class="dropdown">
					<button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="bx bx-dots-vertical-rounded"></i>
					</button>

				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<div class="d-flex flex-column align-items-center gap-1">
						<h2 class="mb-2"><?= $alarms?></h2>
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
								<small class="fw-semibold"><?= $alarmsActive?></small>
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
								<small class="fw-semibold"><?= $alarmsSuspend?></small>
							</div>
						</div>
					</li>

				</ul>
			</div>
		</div>
	</div>
	<!--/ Order Statistics -->

	<!-- Expense Overview -->
	<div class="col-md-6 col-lg-4 order-1 mb-4">
		<div class="card h-100">
			<div class="card-header">
				<ul class="nav nav-pills" role="tablist">
					<li class="nav-item">
						<button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income" aria-selected="true">
							Robo
						</button>
					</li>
					<li class="nav-item">
						<button type="button" class="nav-link" role="tab">Violencia</button>
					</li>
					<li class="nav-item">
						<button type="button" class="nav-link" role="tab">Incendio</button>
					</li>
				</ul>
			</div>
			<div class="card-body px-0">
				<div class="tab-content p-0">
					<div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
						<div class="d-flex p-4 pt-3">
							<div class="avatar flex-shrink-0 me-3">
								<img src="<?= base_url('resources/layout/assets/img/icons/unicons/wallet.png') ?>" alt="User" />
							</div>
							<div>
								<small class="text-muted d-block">Seguimiento de activación de alarmas</small>
								<div class="d-flex align-items-center">
									<h6 class="mb-0 me-1">459</h6>
									<small class="text-success fw-semibold">
										<i class="bx bx-chevron-up"></i>
										42.9%
									</small>
								</div>
							</div>
						</div>
						<div id="incomeChart"></div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!--/ Expense Overview -->

	<!-- Transactions -->
	<div class="col-md-6 col-lg-4 order-2 mb-4">
		<div class="card h-100">
			<div class="card-header d-flex align-items-center justify-content-between">
				<h5 class="card-title m-0 me-2">Historial de notificaciones</h5>
				<div class="dropdown">
					<button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="bx bx-dots-vertical-rounded"></i>
					</button>
					<div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
						<a class="dropdown-item" href="javascript:void(0);">Ver mas</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<ul class="p-0 m-0">

				<?php if($historyNotifications):  $i=0; ?>
					<?php foreach ($historyNotifications as $row):
						$i =$i+1;
						if($i <=5):
						?>
						<li class="d-flex mb-4 pb-1">
							<div class="avatar flex-shrink-0 me-3">
								<img src="<?= base_url('resources/layout/assets/img/icons/unicons/chart.png') ?>" alt="User" class="rounded" />
							</div>
							<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
								<div class="me-2">
									<small class="text-muted d-block mb-1">Notificación</small>
									<h6 class="mb-0"><?= $row->type?></h6>
								</div>
								<div class="user-progress d-flex align-items-center gap-1">
									<h6 class="mb-0"><?= $row->name." ".$row->last_name ?></h6>
								</div>
							</div>
						</li>
					<?php endif; endforeach;?>
				<?php endif;?>

				</ul>
			</div>
		</div>
	</div>
	<!--/ Transactions -->
</div>


<!-- HIDDENS STADISTICS-->
<input type="hidden" name="alarmsActive" value="<?=$alarmsActive?>">
<input type="hidden" name="alarmsSuspend" value="<?=$alarmsSuspend?>">
