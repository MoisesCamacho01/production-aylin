<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class ManagersController extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
	 $this->load->model('Manager_model');
  }

  public function index($submenu)
	{
		$js = [
			'resources/librerias/paginator/paginator.js?t=4',
			'resources/src/js/managers.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Encargados',
			'js' => $js,
			'url' => site_url('managers/search'),
			'quantity'=> count($this->Manager_model->getAll()),
		];


		$this->page = 'app/admin/managers/index';
		$this->layout();
	}

	public function getRegister($id)
	{
		$answer = $this->Manager_model->getForId($id);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Encargado encontrado';
		$this->response->message->message = 'El Encargado no fue encontrado';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'El Encargado fue encontrado';
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();
		$this->setTable('alarm_manager');
		$this->response->message->type = 'error';
		$this->response->message->title = "Encargado Creado";
		$this->response->message->message = "El Encargado no fue creado con éxito";

		$name = htmlspecialchars($this->input->post('name'));
		$lastName = htmlspecialchars($this->input->post('last_name'));
		$phone = htmlspecialchars($this->input->post('phone'));
		$mobile = htmlspecialchars($this->input->post('mobile'));

		$value = $validate->validate([
			["name" => "El nombre", "type" => "string", "value" => $name, "min" => 1, "max" => 50, "required" => true],
			["name" => "El apellido", "type" => "string", "value" => $lastName, "min" => 1, "max" => 50, "required" => true],
			["name" => "El Teléfono", "type" => "number", "value" => $phone, "min" => 0, "max" => 9, "required" => false],
			["name" => "El Celular", "type" => "number", "value" => $mobile, "min" => 0, "max" => 10, "required" => false],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {

			$data = [
				"id" => $this->generateId(),
				"name" => $name,
				"last_name" => $lastName,
				"phone" => $phone,
				"mobile" => $mobile,
				"id_action" => 'ac01',
				"created_at" => date('Y-m-d H:i:s'),
				"updated_at" => date('Y-m-d H:i:s')
			];

			$this->response->message->title = "Encargado Creado";
			$this->response->message->message = "El Encargado no fue creado con éxito";

			if ($this->Manager_model->insert($data)) {
				$this->response->message->type = 'success';
				$this->response->message->message = "El Encargado fue creado con éxito";
			}
		}

		echo json_encode($this->response);
	}

	public function update()
	{
		$validate = new ValidateController();
		$this->setTable('alarm_manager');
		$this->response->message->type = 'error';
		$this->response->message->title = "Encargado Creado";
		$this->response->message->message = "El Encargado no fue actualizado con éxito";

		$name = htmlspecialchars($this->input->post('name'));
		$lastName = htmlspecialchars($this->input->post('last_name'));
		$phone = htmlspecialchars($this->input->post('phone'));
		$mobile = htmlspecialchars($this->input->post('mobile'));

		$value = $validate->validate([
			["name" => "El nombre", "type" => "string", "value" => $name, "min" => 1, "max" => 50, "required" => true],
			["name" => "El apellido", "type" => "string", "value" => $lastName, "min" => 1, "max" => 50, "required" => true],
			["name" => "El Teléfono", "type" => "number", "value" => $phone, "min" => 0, "max" => 9, "required" => false],
			["name" => "El Celular", "type" => "number", "value" => $mobile, "min" => 0, "max" => 10, "required" => false],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {
			$data = [
				"name" => $name,
				"last_name" => $lastName,
				"phone" => $phone,
				"mobile" => $mobile,
				"id_action" => 'ac02',
				"updated_at" => date('Y-m-d H:i:s')
			];

			$this->response->message->title = "Encargado actualizado";
			$this->response->message->message = "El Encargado no fue actualizado con éxito";

			if ($this->Manager_model->updated($data, $this->input->post('id'))) {
				$this->response->message->type = 'success';
				$this->response->message->message = "El Encargado fue actualizado con éxito";
			}
		}

		echo json_encode($this->response);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Encargado eliminado";
		$this->response->message->message = "El Encargado no fue eliminado con éxito";

		$data = [
			"id_action" => 'ac03'
		];

		if ($this->Manager_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = "El Encargado fue eliminado con éxito";
		}
		echo json_encode($this->response);
	}

	public function suspend()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Encargado suspendido";
		$this->response->message->message = "El Encargado no fue suspendido con éxito";

		$data = [
			"id_action" => 'ac04'
		];

		if ($this->Manager_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = "El Encargado fue suspendido con éxito";
		}
		echo json_encode($this->response);
	}

	public function active()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Encargado activado";
		$this->response->message->message = "El Encargado no fue activado con éxito";

		$data = [
			"id_action" => 'ac01'
		];

		if ($this->Manager_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = "El Encargado fue activado con éxito";
		}
		echo json_encode($this->response);
	}

	public function search()
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->Manager_model->search($search, $start, $limit);
		$table = htmlspecialchars_decode($this->generateTable($getSearch));
		$this->response->data = $table;
		$this->response->message->type = 'success';
		$this->response->message->title = "Registro Encontrado";
		$this->response->message->message = "El registro fue encontrado con éxito";

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
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->name} {$row->last_name}</strong></td>
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->phone}</strong></td>
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->mobile}</strong></td>
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
		$thead = ['N°', 'NOMBRE', 'APELLIDO','TELEFONO', 'CELULAR', 'ESTADO'];
		$tbody = $this->Manager_model->getAll();
		$data = [
			'title' => 'Encargados',
			'titleDocument' => 'Lista de encargados',
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
		$header = ['NOMBRE', 'APELLIDO', 'TELEFONO', 'CELULAR', 'ESTADO'];
		$users = $this->Manager_model->getAll();
		$this->excelGenerate($header, $users, 'encargados');
	}
}


/* End of file AlarmManagerController.php */
/* Location: ./application/controllers/AlarmManagerController.php */
