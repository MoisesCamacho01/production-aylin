<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

class PermissionsUserController
{
	protected $User;
	protected $sidebar = "";
	protected $topButtons = "";
	protected $optionButtonTable = "";
	protected $MenuPermission_model;
	protected $SubMenuPermission_model;
	protected $buttonsPermissions_model;

	public function __construct($user, $menu, $subMenu, $buttons)
	{
		$this->User = $user;
		$this->MenuPermission_model = $menu;
		$this->SubMenuPermission_model = $subMenu;
		$this->buttonsPermissions_model = $buttons;
	}

	public function getSidebar(){
		$this->permissionMenu();
		return $this->sidebar;
	}

	public function permissionMenu(){
		$menus = $this->MenuPermission_model->getAll();
		$template = "";
		if($this->User->id == 'U001'){
			foreach ($menus as $row) {
				$url = "";
				if($row->id == "MP001"){
					$url = site_url('dashboard');

					$template.="
					<li class='menu-item active'>
						<a href='$url' class='menu-link'>
							<i class='menu-icon tf-icons bx $row->icon'></i>
							<div data-i18n='Analytics'>TABLERO</div>
						</a>
					</li>
					";
				}else{
					if($row->id != 'MP007' && $row->id != 'MP0010' && $row->id != 'MP0012'){
						$subMenus = $this->SubMenuPermission_model->getAll($row->id);

						$template .= "
						<li class='menu-item'>
							<a href='javascript:void(0);' class='menu-link menu-toggle'>
							<i class='menu-icon tf-icons bx $row->icon'></i>
								<div data-i18n='Layouts'>$row->name</div>
							</a>
							<ul class='menu-sub'>";
						foreach ($subMenus as $submenu) {
							if($submenu->id == 'SMP008' || $submenu->id == 'SMP009' || $submenu->id == 'SMP0010'){
								$url = base_url().$submenu->url.'/'.$submenu->id;
							}else{
								$url = base_url().$submenu->id.'/'.$submenu->url;
							}

							$template .="
									<li class='menu-item'>
										<a href='$url' class='menu-link'>
											<div data-i18n='Without menu'>$submenu->name</div>
										</a>
									</li>";
						}
						$template .="
							</ul>
						</li>";
					}
				}


			}
		}else{
			$menus = $this->MenuPermission_model->getMenuAssign($this->User->id_user_type);
			foreach ($menus as $row) {
				$url = "";
				if($row->id == "MP001"){
					$url = site_url('dashboard');

					$template.="
					<li class='menu-item active'>
						<a href='$url' class='menu-link'>
							<i class='menu-icon tf-icons bx $row->icon'></i>
							<div data-i18n='Analytics'>TABLERO</div>
						</a>
					</li>
					";
				}else{
					if($row->id != 'MP007' && $row->id != 'MP0010' && $row->id != 'MP0012'){
						$subMenus = $this->SubMenuPermission_model->getMenuAssign($row->id, $this->User->id_user_type);

						$template .= "
						<li class='menu-item'>
							<a href='javascript:void(0);' class='menu-link menu-toggle'>
							<i class='menu-icon tf-icons bx $row->icon'></i>
								<div data-i18n='Layouts'>$row->name</div>
							</a>
							<ul class='menu-sub'>";
						foreach ($subMenus as $submenu) {
							if($submenu->id == 'SMP009' || $submenu->id == 'SMP0010'){
								$url = base_url().$submenu->url.'/'.$submenu->id;
							}else{
								$url = base_url().$submenu->id.'/'.$submenu->url;
							}
							$template .="
									<li class='menu-item'>
										<a href='$url' class='menu-link'>
											<div data-i18n='Without menu'>$submenu->name</div>
										</a>
									</li>";
						}
						$template .="
							</ul>
						</li>";
					}
				}
			}

		}
		$this->sidebar = $template;
	}

	public function buttonSuperior($submenu){

		$buttons = $this->buttonsPermissions_model->getAll('TB001');

		if($this->User->id == 'U001'){
			return ($buttons) ? $buttons : false;
		}else{
			$buttons = $this->buttonsPermissions_model->getButtonAssign($submenu, $this->User->id_user_type, 'TB001');
			return ($buttons) ? $buttons : false;
		}
	}

	public function buttonMenu($submenu){
		$buttons = $this->buttonsPermissions_model->getAll('TB002');
		if($this->User->id == 'U001'){
			return ($buttons) ? $buttons : false;
		}else{
			$buttons = $this->buttonsPermissions_model->getButtonAssign($submenu, $this->User->id_user_type, 'TB002');
			return ($buttons) ? $buttons : false;
		}
	}

}


/* End of file PermissionsUserController.php */
/* Location: ./application/controllers/PermissionsUserController.php */
