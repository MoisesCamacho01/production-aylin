<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class UsersController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("User_model");
		$this->load->model("User_Type_model");
		$this->load->model("DocumentType_model");
		$this->load->model("Country_model");
		$this->load->model("State_model");
	}

	public function index($submenu)
	{

		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/users.js?t=5',
			'resources/src/js/profile.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;
		$this->data = [
			'title' => 'Usuarios',
			'js' => $js,
			'userTypes' => $this->User_Type_model->getAll(),
			'country'=> $this->Country_model->getForId('C001'),
			'states'=> $this->State_model->getAll(),
			'documentTypes'=> $this->DocumentType_model->getAll(),
			'url' => site_url('usuarios/search'),
			'quantity' => count($this->User_model->getAll())
		];

		$this->page = 'app/admin/users/index';
		$this->layout();
	}

	public function getRegister($id)
	{
		$answer = $this->User_model->getForId($id);
		$this->response->message->type = 'error';
		$this->response->message->title = 'Usuario encontrado';
		$this->response->message->message = 'El usuario no fue encontrado';

		if ($answer) {

			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'El usuario fue encontrado';
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();
		$this->setTable('users');
		$this->response->message->type = 'error';
		$this->response->message->title = "Usuario Creado";
		$this->response->message->message = "El usuario no pudo ser creado con éxito";

		$username = htmlspecialchars($this->input->post('username'));
		$email = htmlspecialchars($this->input->post('email'));
		$userType = htmlspecialchars($this->input->post('userType'));

		$value = $validate->validate([
			["name" => "El nombre de usuario", "type" => "string", "value" => $username, "min" => 6, "max" => 50, "required" => true],
			["name" => "El Correo", "type" => "email", "value" => $email, "min" => 1, "max" => 255, "required" => true],
			["name" => "La contraseña", "type" => "string", "value" => $this->input->post('password'), "min" => 6, "max" => 18, "required" => true],
			["name" => "El tipo de usuario", "type" => "string", "value" => $userType, "min" => 1, "max" => 50, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {
			$valueDuplicate = $this->duplicate([
				["attribute" => "user_name", "value" => $this->input->post('username'), "message"=>"El nombre de usuario"],
				["attribute" => "email", "value" => $this->input->post('email'), "message"=>"El e-mail"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"id" => $this->generateId(),
					"user_name" => $username,
					"email" => $email,
					"password" => password_hash($this->input->post('password'), PASSWORD_BCRYPT, ["cost" => 11]),
					"id_user_type" => $userType,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->title = "Usuario Creado";
				$this->response->message->message = "El usuario no pudo ser creado con éxito";

				$message = $this->load->view('email/createAccount', $data, true);

				if ($this->User_model->insert($data)) {
					if($this->sendEmail($email, 'Cuenta creada', $message)){
						$this->response->message->type = 'success';
						$this->response->message->message = "El usuario fue creado con éxito";
					}
				}
			}
		}

		echo json_encode($this->response);
	}

	public function update()
	{
		$validate = new ValidateController();
		$this->setTable('users');
		$this->setId($this->input->post('id'));

		$username = htmlspecialchars($this->input->post('username'));
		$email = htmlspecialchars($this->input->post('email'));
		$userType = htmlspecialchars($this->input->post('userType'));

		$value = $validate->validate([
			["name" => "Nombre de usuario", "type" => "string", "value" => $username, "min" => 6, "max" => 50, "required" => true],
			["name" => "El correo", "type" => "email", "value" => $email, "min" => 1, "max" => 255, "required" => true],
			["name" => "El tipo de usuario", "type" => "string", "value" => $userType, "min" => 1, "max" => 50, "required" => true],
		]);

		$this->response->message->type = 'error';
		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			$valueDuplicate = $this->duplicateUpdate([
				["attribute" => "user_name", "value" => $this->input->post('username'), "message"=>"El nombre de usuario"],
				["attribute" => "email", "value" => $this->input->post('email'), "message"=>"El e-mail"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"user_name" => $username,
					"email" => $email,
					"id_user_type" => $userType,
					"id_action" => 'ac02',
					"updated_at" => date('Y-m-d H:i:s')
				];

				if ($this->input->post('password') != '') {
					$data["password"] = password_hash($this->input->post('password'), PASSWORD_BCRYPT, ["cost" => 11]);
				}

				$this->response->message->title = "Usuario Actualizado";
				$this->response->message->message ="El usuario no pudo ser actualizado con éxito";

				if ($this->User_model->updated($data, $this->input->post('id'))) {
					$this->response->message->type = 'success';
					$this->response->message->message ="El usuario pudo ser actualizado con éxito";
				}
			}
		}


		echo json_encode($this->response);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Usuario Eliminado";
		$this->response->message->message = "El usuario no pudo ser eliminado";

		$data = [
			"id_action" => 'ac03'
		];

		if ($this->User_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = "El usuario fue eliminado";
		}
		echo json_encode($this->response);
	}

	public function suspend()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Usuario Suspendido";
		$this->response->message->message = "El usuario no pudo ser suspendido con éxito";

		$data = [
			"id_action" => 'ac04'
		];

		if ($this->User_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->title = "Usuario Suspendido";
			$this->response->message->message = "El usuario fue suspendido con éxito";
		}
		echo json_encode($this->response);
	}

	public function active()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Usuario Activado";
		$this->response->message->message = "El usuario no pudo ser activado con éxito";

		$data = [
			"id_action" => 'ac01'
		];

		if ($this->User_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->title = "Usuario Activado";
			$this->response->message->message = "El usuario fue activado con éxito";
		}
		echo json_encode($this->response);
	}

	public function search()
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->User_model->search($search, $start, $limit);
		$table = htmlspecialchars_decode($this->generateTable($getSearch));
		$this->response->data = $table;
		$this->response->message->type = 'success';
		$this->response->message->title = "Registro Encontrado";
		$this->response->message->message = "Registros encontrados con éxito";

		echo json_encode($this->response);
	}

	public function generateTable($getRegisters)
	{
		$template = '<tr><td><p>No se encontraron datos</p></td></tr>';
		if ($getRegisters) {
			$i = 0;
			$template = '';
			foreach ($getRegisters as $row) {
				$i++;
				$template .= "<tr>
					<td>{$i}</td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->user_name}</strong></td>
					<td>{$row->email}</td>
					<td>{$row->user_type}</td>
					<td>";
				if ($row->action == 'create') :
					$template .= "<span class='badge bg-label-success me-1'>ACTIVO</span>";
				elseif ($row->action == 'suspend') :
					$template .= "<span class='badge bg-label-warning me-1'>SUSPENDIDO</span>";
				elseif ($row->action == 'edit') :
					$template .= "<span class='badge bg-label-primary me-1'>EDITADO</span>";
				elseif ($row->action == 'delete') :
					$template .= "<span class='badge bg-label-danger me-1'>ELIMINADO</span>";
				endif;
				$template .= "
					</td>
					<td>
						<div class='dropdown'>
							<button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
								<i class='bx bx-dots-vertical-rounded'></i>
							</button>
							<div class='dropdown-menu'>";

							if($this->buttonMenu($this->session->userdata('submenu'))){
								foreach ($this->buttonMenu($this->session->userdata('submenu')) as $rowB) {
									if ($row->action == 'suspend') {
										if($rowB->id == 'BP003'){
											$template .= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#activeModal' dataId='{$row->id}' href='javascript:void(0);'><i class='bx bx-user-check'></i> $rowB->name</a>";
										}
									} else {
										if($rowB->id == 'BP002'){
											$template .= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#suspendModal' dataId='{$row->id}' href='javascript:void(0);'><i class='bx bx-user-x'></i> $rowB->name</a>";
										}
									}

									if($rowB->id == 'BP004'){
										$template .= "<a class='dropdown-item btnInputHidden btnGetForId' dataId='{$row->id}' data-bs-toggle='modal' data-bs-target='#updateModal' href='javascript:void(0);'><i class='bx bx-edit-alt me-1'></i> $rowB->name</a>";
									}

									if($rowB->id == 'BP006'){
										$template .= "<a class='dropdown-item btnInputHidden btnGetProfile' dataId='{$row->id}' data-bs-toggle='modal' data-bs-target='#profileModal' href='javascript:void(0);'><i class='bx bx-edit-alt me-1'></i> $rowB->name</a>";
									}

									if ($row->action == 'delete') {
										if($rowB->id == 'BP003'){
											$template .= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#activeModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-user-check me-1'></i> $rowB->name</a>";
										}
									} else {
										if($rowB->id == 'BP005'){
											$template .= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#deleteModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-trash me-1'></i> $rowB->name</a>";
										}
									}
								}
							}

				$template .= "
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
		$thead = ['N°', 'USUARIO', 'EMAIL', 'TIPO DE USUARIO', 'ESTADO'];
		$tbody = $this->User_model->getAll();
		$data = [
			'title' => 'Usuarios',
			'titleDocument' => 'Lista de Usuarios',
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
		$header = ['NOMBRE', 'EMAIL', 'TIPO DE USUARIO', 'ESTADO'];
		$users = $this->User_model->getAll();
		$this->excelGenerate($header, $users, 'users');
	}
}


/* End of file UsersController.php */
/* Location: ./application/controllers/UsersController.php */
