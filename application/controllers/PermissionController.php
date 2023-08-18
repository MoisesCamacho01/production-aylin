<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class PermissionController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MenuPermission_model');
		$this->load->model('SubMenuPermission_model');
		$this->load->model('ButtonPermission_model');
		$this->load->model('User_Type_model');
		$this->load->model('AssignMenuPermission_model');
		$this->load->model('AssignSubMenuPermission_model');
		$this->load->model('AssignButtonMenuPermission_model');
	}

	public function index($submenu, $id)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/permission.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Permission',
			'menuPermission' => $this->User_Type_model->getForId($id),
			'assignMenuPermissions' => $this->AssignMenuPermission_model->getAll($id),
			'assignSubMenuPermissions' => $this->AssignSubMenuPermission_model->getAll($id),
			'assignButtonPermissions' => $this->AssignButtonMenuPermission_model->getAll($id),
			'menus' => $this->MenuPermission_model->getAll(),
			'subMenus' => $this->SubMenuPermission_model->getAll(),
			'buttonsTop' => $this->ButtonPermission_model->getAll('TB001'),
			'buttonsMenu' => $this->ButtonPermission_model->getAll('TB002'),
			'js' => $js,
		];

		$this->page = 'app/admin/users/userTypes/permisos/index';
		$this->layout();
	}

	public function updateMenu($id_user)
	{
		$validate = new ValidateController();

		$this->response->message->type = 'error';
		$this->response->message->title = "Permisos de usuario";
		$this->response->message->message = "El permiso no puede ser asignado";

		$id = htmlspecialchars($this->input->post('id'));
		$tipo = htmlspecialchars($this->input->post('tipo'));

		$value = $validate->validate([
			["name" => "Identificador", "type" => "string", "value" => $id, "min" => 1, "max" => 255, "required" => true],
			["name" => "El tipo", "type" => "string", "value" => $tipo, "min" => 1, "max" => 50, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			if($tipo == "insert"){
				$this->response->message->title = "Permisos de usuario";
				$this->response->message->message = "El permiso no puede ser asignado";

				if($this->AssignMenuPermission_model->delete($id_user, $id)){
					$data = [
						"id" => $this->generateId(),
						"id_menu_permission" => $id,
						"id_user_type" => $id_user,
						"id_action" => 'ac01',
						"created_at" => date('Y-m-d H:i:s'),
						"updated_at" => date('Y-m-d H:i:s')
					];

					$this->response->message->title = "Permiso Asignado";
					$this->response->message->message = "El usuario no pudo ser creado con éxito";

					if ($this->AssignMenuPermission_model->insert($data)) {
						$this->response->message->type = 'success';
						$this->response->message->message = "El permiso pudo ser asignado";
					}
				}
			}else{
				$this->response->message->title = "Permisos de usuario";
				$this->response->message->message = "El permiso no pudo ser modificado";

				if($this->AssignMenuPermission_model->delete($id_user, $id)){
					$this->response->message->type = "success";
					$this->response->message->message = "El permiso fue modificado";
				}
			}
		}

		echo json_encode($this->response);
	}

	public function updateSubMenu($id_user)
	{
		$validate = new ValidateController();

		$this->response->message->type = 'error';
		$this->response->message->title = "Permisos de usuario";
		$this->response->message->message = "El permiso no puede ser asignado";

		$id = htmlspecialchars($this->input->post('id'));
		$tipo = htmlspecialchars($this->input->post('tipo'));

		$value = $validate->validate([
			["name" => "Identificador", "type" => "string", "value" => $id, "min" => 1, "max" => 255, "required" => true],
			["name" => "El tipo", "type" => "string", "value" => $tipo, "min" => 1, "max" => 50, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			if($tipo == "insert"){
				$this->response->message->title = "Permisos de usuario";
				$this->response->message->message = "El permiso no puede ser asignado";

				if($this->AssignSubMenuPermission_model->delete($id_user, $id)){
					$data = [
						"id" => $this->generateId(),
						"id_submenu_permission" => $id,
						"id_user_type" => $id_user,
						"id_action" => 'ac01',
						"created_at" => date('Y-m-d H:i:s'),
						"updated_at" => date('Y-m-d H:i:s')
					];

					$this->response->message->title = "Permiso Asignado";
					$this->response->message->message = "El usuario no pudo ser creado con éxito";

					if ($this->AssignSubMenuPermission_model->insert($data)) {
						$this->response->message->type = 'success';
						$this->response->message->message = "El permiso pudo ser asignado";
					}
				}
			}else{
				$this->response->message->title = "Permisos de usuario";
				$this->response->message->message = "El permiso no pudo ser modificado";

				if($this->AssignSubMenuPermission_model->delete($id_user, $id)){
					$this->response->message->type = "success";
					$this->response->message->message = "El permiso fue modificado";
				}
			}
		}

		echo json_encode($this->response);
	}

	public function updateButton($id_user)
	{
		$validate = new ValidateController();

		$this->response->message->type = 'error';
		$this->response->message->title = "Permisos de usuario";
		$this->response->message->message = "El permiso no puede ser asignado";

		$id = htmlspecialchars($this->input->post('id'));
		$tipo = htmlspecialchars($this->input->post('tipo'));
		$submenu = htmlspecialchars($this->input->post('submenu'));

		$value = $validate->validate([
			["name" => "Identificador", "type" => "string", "value" => $id, "min" => 1, "max" => 255, "required" => true],
			["name" => "El SubMenu", "type" => "string", "value" => $submenu, "min" => 1, "max" => 255, "required" => true],
			["name" => "El tipo", "type" => "string", "value" => $tipo, "min" => 1, "max" => 50, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			if($tipo == "insert"){
				$this->response->message->title = "Permisos de usuario";
				$this->response->message->message = "El permiso no puede ser asignado";

				if($this->AssignButtonMenuPermission_model->delete($id_user, $id, $submenu)){
					$data = [
						"id" => $this->generateId(),
						"id_submenu_permission" => $submenu,
						"id_button_permission" => $id,
						"id_user_type" => $id_user,
						"id_action" => 'ac01',
						"created_at" => date('Y-m-d H:i:s'),
						"updated_at" => date('Y-m-d H:i:s')
					];

					$this->response->message->title = "Permiso Asignado";
					$this->response->message->message = "El usuario no pudo ser creado con éxito";

					if ($this->AssignButtonMenuPermission_model->insert($data)) {
						$this->response->message->type = 'success';
						$this->response->message->message = "El permiso pudo ser asignado";
					}
				}
			}else{
				$this->response->message->title = "Permisos de usuario";
				$this->response->message->message = "El permiso no pudo ser modificado";

				if($this->AssignButtonMenuPermission_model->delete($id_user, $id, $submenu)){
					$this->response->message->type = "success";
					$this->response->message->message = "El permiso fue modificado";
				}
			}
		}

		echo json_encode($this->response);
	}
}


/* End of file PermissionController.php */
/* Location: ./application/controllers/PermissionController.php */
