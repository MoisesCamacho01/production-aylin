<h4 class="fw-bold py-3 mb-4">
	Permisos de usuario
</h4>
<!-- Basic Bootstrap Table -->

<?php if ($menus) : ?>
	<?php foreach ($menus as $menu) : ?>
		<div class="card mb-2">
			<h5 class="card-header"><?= $menu->name ?>
				<?php
				$valorBuscado = $menu->id;
				$claveEncontrada = array_search(true, array_map(function ($obj) use ($valorBuscado) {
					return $obj->id_menu_permission === $valorBuscado;
				  }, $assignMenuPermissions));
				?>
				<?php if($claveEncontrada !== false): ?>
					<input class="form-check-input mt-0 checkMenu" type="checkbox" value="<?= $menu->id ?>" checked/>
				<?php else: ?>
					<input class="form-check-input mt-0 checkMenu" type="checkbox" value="<?= $menu->id ?>"/>
				<?php endif; ?>

			</h5>
			<div class="card-body">
				<?php if ($subMenus) : ?>
					<?php foreach ($subMenus as $subMenu) : ?>
						<?php if ($subMenu->id_menu == $menu->id) : ?>
							<div class="row">
								<!-- Basic List group -->
								<div class="col-12">
									<div class="demo-inline-spacing mt-3">
										<ul class="list-group">
											<li class="list-group-item d-flex justify-content-between align-items-center active">
												<?= $subMenu->name; ?>
												<?php
												$valorBuscado = $subMenu->id;
												$claveEncontrada = array_search(true, array_map(function ($obj) use ($valorBuscado) {
													return $obj->id_submenu_permission === $valorBuscado;
												}, $assignSubMenuPermissions));
												?>
												<?php if($claveEncontrada !== false): ?>
													<input class="form-check-input mt-0 checkSubMenu" type="checkbox" value="<?= $subMenu->id ?>" checked/>
												<?php else: ?>
													<input class="form-check-input mt-0 checkSubMenu" type="checkbox" value="<?= $subMenu->id ?>"/>
												<?php endif; ?>
											</li>
											<?php if($subMenu->id == 'SMP0015' || $subMenu->id == 'SMP0016' || $subMenu->id == 'SMP0017' || $subMenu->id == 'SMP0018'): ?>
												<?php if ($buttonsTop) : ?>
													<?php foreach ($buttonsTop as $button) : ?>
														<?php if($button->id != 'BP001'):?>
															<li class="list-group-item d-flex justify-content-between align-items-center">
																<?= $button->name?>

																<?php
																	$encontrado = false;
																	foreach ($assignButtonPermissions as $objeto) {
																		$encontradoSubMenu = ($objeto->id_submenu_permission === $subMenu->id) ? true : false;
																		$encontradoButton = ($objeto->id_button_permission === $button->id) ? true : false;
																		if($encontradoButton == true && $encontradoSubMenu == true){
																			$encontrado = true;
																			break;
																		}
																}
																?>
																<?php if($encontrado): ?>
																	<input class="form-check-input mt-0 checkButton" type="checkbox" submenu="<?= $subMenu->id ?>" value="<?= $button->id ?>" checked/>
																<?php else: ?>
																	<input class="form-check-input mt-0 checkButton" type="checkbox" submenu="<?= $subMenu->id ?>" value="<?= $button->id ?>"/>
																<?php endif; ?>
															</li>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
											<?php endif; ?>


											<?php if ($subMenu->id != 'SMP001' && $subMenu->id != 'SMP0015' && $subMenu->id != 'SMP0016' && $subMenu->id != 'SMP0017' && $subMenu->id != 'SMP0018') : ?>
												<?php if ($buttonsTop) : ?>
													<?php foreach ($buttonsTop as $button) : ?>

														<li class="list-group-item d-flex justify-content-between align-items-center">
															<?= $button->name?>

															<?php
																$encontrado = false;
																foreach ($assignButtonPermissions as $objeto) {
																	$encontradoSubMenu = ($objeto->id_submenu_permission === $subMenu->id) ? true : false;
																	$encontradoButton = ($objeto->id_button_permission === $button->id) ? true : false;
																	if($encontradoButton == true && $encontradoSubMenu == true){
																		$encontrado = true;
																		break;
																	}
															  }
															?>
															<?php if($encontrado): ?>
																<input class="form-check-input mt-0 checkButton" type="checkbox" submenu="<?= $subMenu->id ?>" value="<?= $button->id ?>" checked/>
															<?php else: ?>
																<input class="form-check-input mt-0 checkButton" type="checkbox" submenu="<?= $subMenu->id ?>" value="<?= $button->id ?>"/>
															<?php endif; ?>
														</li>

													<?php endforeach; ?>
												<?php endif; ?>
												<?php if ($buttonsMenu) : ?>
													<?php foreach ($buttonsMenu as $button) : ?>
														<?php
																$encontrado = false;
																foreach ($assignButtonPermissions as $objeto) {
																	$encontradoSubMenu = ($objeto->id_submenu_permission === $subMenu->id) ? true : false;
																	$encontradoButton = ($objeto->id_button_permission === $button->id) ? true : false;
																	if($encontradoButton == true && $encontradoSubMenu == true){
																		$encontrado = true;
																		break;
																	}
															  }
														?>
														<?php $inputButton = '';
														if($encontrado){
															$inputButton = "<input class='form-check-input mt-0 checkButton' type='checkbox' submenu='$subMenu->id' value='$button->id' checked/>";
														}else{
															$inputButton = "<input class='form-check-input mt-0 checkButton' type='checkbox' submenu='$subMenu->id' value='$button->id'/>";
														}
														?>
														<?php if($button->id != 'BP006' && $button->id != 'BP007' && $button->id != 'BP008' && $button->id != 'BP009' && $button->id != 'BP0012' && $button->id != 'BP0013' && $button->id != 'BP0014' && $button->id != 'BP0015' && $button->id != 'BP0016'):?>
															<li class="list-group-item d-flex justify-content-between align-items-center">
																<?= $button->name?>
																<?= $inputButton?>
															</li>
														<?php endif;?>

														<!-- BUTTON PROFILE -->
														<?php if(($subMenu->id == 'SMP002') && ($button->id == 'BP006')):?>
															<li class="list-group-item d-flex justify-content-between align-items-center">
																<?= $button->name?>
																<?= $inputButton?>
															</li>
														<?php endif;?>

														<!-- button parroquia -->
														<?php if(($subMenu->id == 'SMP007') && ($button->id == 'BP0012')):?>
															<li class="list-group-item d-flex justify-content-between align-items-center">
																<?= $button->name?>
																<?= $inputButton?>
															</li>
														<?php endif;?>

														<!-- button barrios -->
														<?php if(($subMenu->id == 'SMP008') && ($button->id == 'BP0013')):?>
															<li class="list-group-item d-flex justify-content-between align-items-center">
																<?= $button->name?>
																<?= $inputButton?>
															</li>
														<?php endif;?>

														<!-- Sectores -->
														<?php if(($subMenu->id == 'SMP009') && ($button->id == 'BP0014')):?>
															<li class="list-group-item d-flex justify-content-between align-items-center">
																<?= $button->name?>
																<?= $inputButton?>
															</li>
														<?php endif;?>

														<!-- btn alarmas dibujar y vizualizar -->
														<?php if(($subMenu->id == 'SMP0010') && ($button->id == 'BP0015' || $button->id == 'BP008' || $button->id == 'BP009')):?>
															<li class="list-group-item d-flex justify-content-between align-items-center">
																<?= $button->name?>
																<?= $inputButton?>
															</li>
														<?php endif;?>

														<!-- btn dibujar y vizualizar -->
														<?php if(($subMenu->id == 'SMP0011') && ($button->id == 'BP008' || $button->id == 'BP009')):?>
															<li class="list-group-item d-flex justify-content-between align-items-center">
																<?= $button->name?>
																<?= $inputButton?>
															</li>
														<?php endif;?>

														<!-- btn campus -->
														<?php if(($subMenu->id == 'SMP0012') && ($button->id == 'BP0016')):?>
															<li class="list-group-item d-flex justify-content-between align-items-center">
																<?= $button->name?>
																<?= $inputButton?>
															</li>
														<?php endif;?>
													<?php endforeach; ?>
												<?php endif; ?>
											<?php endif; ?>
										</ul>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>
<!--/ Basic Bootstrap Table -->

<input type="hidden" name="idInstitution" value="<?= $menuPermission->id ?>">
