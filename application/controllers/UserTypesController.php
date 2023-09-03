<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class UserTypesController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserType_model');
	}

	public function index($submenu)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/userTypes.js?t=4',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Countries',
			'js' => $js,
			'url' => site_url('userTypes/search'),
			'quantity' => count($this->UserType_model->getAll())
		];

		$this->page = 'app/admin/users/userTypes/index';
		$this->layout();
	}

	public function getRegister($id)
	{
		$answer = $this->UserType_model->getForId($id);

		$this->response->message->type = 'error';
		$this->response->message->title = "Tipo de Usuario";
		$this->response->message->message = "El Tipo de Usuario no fue encontrado";

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = "El Tipo de Usuario fue encontrado con éxito";
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();
		$this->setTable('user_types');
		$this->response->message->type = 'error';
		$this->response->message->title = "Tipo de Usuario Creado";
		$this->response->message->message = "El Tipo de Usuario no pudo ser creado con éxito";

		$name = htmlspecialchars($this->input->post('name'));

		$value = $validate->validate([
			["name" => "nombre de usuario", "type" => "string", "value" => $name, "min" => 1, "max" => 50, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			$valueDuplicate = $this->duplicate([
				["attribute" => "name", "value" => $name, "message"=>"El tipo de usuario que ingresaste ya existe"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if($valueDuplicate->status){
				$data = [
					"id" => $this->generateId(),
					"name" => $name,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->type = 'error';
				$this->response->message->title = "Tipo de Usuario Creado";
				$this->response->message->message = "El Tipo de Usuario no pudo ser creado con éxito";

				if ($this->UserType_model->insert($data)) {
					$this->response->message->type = 'success';
					$this->response->message->message = "El Tipo de Usuario fue creado con éxito";
				}
			}
		}


		echo json_encode($this->response);
	}

	public function update()
	{

		$validate = new ValidateController();
		$this->setTable('user_types');
		$this->setId($this->input->post('id'));

		$this->response->message->type = 'error';
		$this->response->message->title = "Tipo de Usuario Actualizado";
		$this->response->message->message = "El Tipo de Usuario no pudo ser actualizado con éxito";

		$name = htmlspecialchars($this->input->post('name'));

		$value = $validate->validate([
			["name" => "nombre de usuario", "type" => "string", "value" => $name, "min" => 1, "max" => 50, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			$valueDuplicate = $this->duplicateUpdate([
				["attribute" => "name", "value" => $name, "message"=>"El tipo de usuario que ingresaste ya existe"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if($valueDuplicate->status){
				$data = [
					"name" => $name,
					"id_action" => 'ac02',
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->type = 'error';
				$this->response->message->title = "Tipo de Usuario Actualizado";
				$this->response->message->message = "El Tipo de Usuario no pudo ser actualizado con éxito";

				if ($this->UserType_model->updated($data, $this->input->post('id'))) {
					$this->response->message->type = 'success';
					$this->response->message->message = "El Tipo de Usuario fue actualizado con éxito";
				}
			}
		}

		echo json_encode($this->response);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->response->message->type = "error";

		$this->table = 'users';
		$existUsers = $this->existRegister('id_user_type', $id);

		$this->response->message->title = "Valores Relacionados";
		$this->response->message->message = $existUsers->message;
		if(!$existUsers->status){
			$this->response->message->title = "Tipo de usuario";
			$this->response->message->message = "El tipo de Usuario no pudo ser eliminado con éxito";

			$data = [
				"id_action" => 'ac03'
			];

			if ($this->UserType_model->updated($data, $id)) {
				$this->response->message->type = "success";
				$this->response->message->title = "Tipo de usuario";
				$this->response->message->message = "El tipo de Usuario fue eliminado con éxito";
			}
		}
		echo json_encode($this->response);
	}

	public function suspend()
	{
		$id = $this->input->post('id');
		$this->response->message->type = "error";
		$this->response->message->title = "Tipo de Usuario";
		$this->response->message->message = "El Tipo de Usuario no pudo ser suspendido con éxito";

		$data = [
			"id_action" => 'ac04'
		];

		if ($this->UserType_model->updated($data, $id)) {

			$this->response->message->type = "success";
			$this->response->message->message = "El Tipo de Usuario fue suspendido con éxito";
		}
		echo json_encode($this->response);
	}

	public function active(){
		$id = $this->input->post('id');
		$this->response->message->type = "error";
		$this->response->message->title = "Tipo de Usuario";
		$this->response->message->message = "El Tipo de Usuario no pudo ser activado con éxito";


		$data = [
			"id_action" => 'ac01'
		];

		if ($this->UserType_model->updated($data, $id)) {
			$this->response->message->type = "success";
			$this->response->message->message = "El Tipo de Usuario fue activado con éxito";
		}
		echo json_encode($this->response);
	}

	public function search(){
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->UserType_model->search($search, $start, $limit);
		$quantity = $this->RegisterLog_model->getSuccessAccess($search, $start, $limit, false);
		$table = htmlspecialchars_decode($this->generateTable($getSearch));
		$this->response->quantity = count($quantity);
		$this->response->data = $table;
		$this->response->message->type = "success";
		$this->response->message->title = "Registro Encontrado";
		$this->response->message->message = "El registro fue encontrado con éxito";

		echo json_encode($this->response);
	}

	public function generateTable($getRegisters){
		$template = '<tr><td><p>No se encontraron datos</p></td></tr>';
		if($getRegisters){
			$i = 0;
			$template = '';
			foreach ($getRegisters as $row) {
				$i++;
				$template.="<tr>
					<td>{$i}</td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>".htmlspecialchars_decode($row->name)."</strong></td>
					<td>";
					if ($row->action == 'create') :
							$template.="<span class='badge bg-label-success me-1'>ACTIVO</span>";
					elseif ($row->action == 'suspend') :
							$template.="<span class='badge bg-label-warning me-1'>SUSPENDIDO</span>";
					elseif ($row->action == 'edit') :
							$template.="<span class='badge bg-label-primary me-1'>EDITADO</span>";
					elseif ($row->action == 'delete') :
							$template.="<span class='badge bg-label-danger me-1'>ELIMINADO</span>";
					endif;
					$template.="
					</td>
					<td>
						<div class='dropdown'>
							<button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
								<i class='bx bx-dots-vertical-rounded'></i>
							</button>
							<div class='dropdown-menu'>";
							if($this->buttonMenu($this->session->userdata('submenu'))){
								foreach ($this->buttonMenu($this->session->userdata('submenu')) as $rowB) {
									if ($row->action == 'suspend'){
										if($rowB->id == 'BP003'){
											$template.= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#activeModal' dataId='{$row->id}' href='javascript:void(0);'><i class='bx bx-user-check'></i> $rowB->name</a>";
										}
									}else{
										if($rowB->id == 'BP002'){
											$template.= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#suspendModal' dataId='{$row->id}' href='javascript:void(0);'><i class='bx bx-user-x'></i> $rowB->name</a>";
										}
									}
									if($rowB->id == 'BP004'){
										$template.="<a class='dropdown-item btnInputHidden btnGetForId' dataId='{$row->id}' data-bs-toggle='modal' data-bs-target='#updateModal' href='javascript:void(0);'><i class='bx bx-edit-alt me-1'></i> $rowB->name</a>";
									}

									if ($row->action == 'delete'){
										if($rowB->id == 'BP003'){
											$template.="<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#activeModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-user-check me-1'></i> $rowB->name</a>";
										}
									}else{
										if($rowB->id == 'BP005'){
											$template.="<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#deleteModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-trash me-1'></i> $rowB->name</a>";
										}
									}
									$submenu = (isset($rowB->id_submenu)) ? $rowB->id_submenu : $this->session->userdata('submenu');
									if($rowB->id == 'BP007'){
										$template .= "<a class='dropdown-item' href='" . site_url($submenu.'/'.'permission/' . $row->id) . "'><i class='bx bx-bell' ></i> $rowB->name</a>";
									}
								}
							}
					$template .="
							</div>
						</div>
					</td>
				</tr>";
			}
		}
		return $template;
	}

	public function pdf()
	{
		$thead = ['N°', 'NOMBRE', 'ESTADO'];
		$tbody = $this->UserType_model->getAll();
		$data = [
			'title' => 'Tipos de usuarios',
			'titleDocument' => 'Listado de los Tipos de Usuarios',
			'thead' => $thead,
			'tbody' => $tbody
		];

		$mPdf = new \Mpdf\Mpdf();
		$document = $this->load->view('pdf/table.php', $data, true);
		$mPdf->WriteHTML($document);
		$mPdf->Output();
	}

	public function excel()
	{
		$header = ['NOMBRE', 'ESTADO'];
		$users = $this->UserType_model->getAll();
		$this->excelGenerate($header, $users, 'userTypes');
	}
}


/* End of file UserTypeController.php */
/* Location: ./application/controllers/UserTypeController.php */
