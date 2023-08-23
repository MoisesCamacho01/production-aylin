<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class DocumentTypesController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('DocumentType_model');
	}

	public function index($submenu)
	{
		$js = [
			'resources/layout/assets/js/ui-modals.js',
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/documentTypes.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Tipos de documentos',
			'js' => $js,
			'url' => site_url('documentTypes/search'),
			'quantity' => count($this->DocumentType_model->getAll())
		];

		$this->page = 'app/admin/users/documentTypes/index';
		$this->layout();
	}

	public function getRegister($id)
	{
		$answer = $this->DocumentType_model->getForId($id);

		$this->response->message->type = 'error';
		$this->response->message->title = "Tipo de identificación";
		$this->response->message->message = "El Tipo de identificación no fue encontrado";

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = "El Tipo de identificación fue encontrado con éxito";
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();
		$this->setTable('document_type');
		$this->response->message->type = 'error';
		$this->response->message->title = "Tipo de identificación creado";
		$this->response->message->message = "El Tipo de identificación no pudo ser creado con éxito";

		$name = htmlspecialchars($this->input->post('name'));

		$value = $validate->validate([
			["name" => "Nombre de la identificación", "type" => "string", "value" => $name, "min" => 1, "max" => 50, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {
			$valueDuplicate = $this->duplicate([
				["attribute" => "name", "value" => $name, "message" => "El tipo de identificación que ingresaste ya existe"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"id" => $this->generateId(),
					"name" => $name,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->type = 'error';
				$this->response->message->title = "Tipo de identificación creado";
				$this->response->message->message = "El Tipo de identificación no pudo ser creado con éxito";

				if ($this->DocumentType_model->insert($data)) {
					$this->response->message->type = 'success';
					$this->response->message->message = "El Tipo de identificación fue creado con éxito";
				}
			}
		}


		echo json_encode($this->response);
	}

	public function update()
	{

		$validate = new ValidateController();
		$this->setTable('document_type');
		$this->setId($this->input->post('id'));

		$this->response->message->type = 'error';
		$this->response->message->title = "Tipo de identificación Actualizada";
		$this->response->message->message = "El Tipo de identificación no pudo ser actualizada con éxito";

		$name = htmlspecialchars($this->input->post('name'));

		$value = $validate->validate([
			["name" => "Nombre de la identificación", "type" => "string", "value" => $name, "min" => 1, "max" => 50, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {
			$valueDuplicate = $this->duplicateUpdate([
				["attribute" => "name", "value" => $name, "message" => "El tipo de identificación que ingresaste ya existe"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"name" => $name,
					"id_action" => 'ac02',
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->type = 'error';
				$this->response->message->title = "Tipo de identificación Actualizada";
				$this->response->message->message = "El Tipo de identificación no pudo ser actualizada con éxito";

				if ($this->DocumentType_model->updated($data, $this->input->post('id'))) {
					$this->response->message->type = 'success';
					$this->response->message->message = "El Tipo de identificación fue actualizada con éxito";
				}
			}
		}

		echo json_encode($this->response);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->response->message->type = "error";

		$this->table = 'profile';
		$existUsers = $this->existRegister('id_document_type', $id);

		$this->response->message->title = "Valores Relacionados";
		$this->response->message->message = $existUsers->message;
		if (!$existUsers->status) {
			$this->response->message->title = "Tipo de identificación";
			$this->response->message->message = "El tipo de identificación no pudo ser eliminado con éxito";

			$data = [
				"id_action" => 'ac03'
			];

			if ($this->DocumentType_model->updated($data, $id)) {
				$this->response->message->type = "success";
				$this->response->message->title = "Tipo de identificación";
				$this->response->message->message = "El tipo de identificación fue eliminado con éxito";
			}
		}
		echo json_encode($this->response);
	}

	public function suspend()
	{
		$id = $this->input->post('id');
		$this->response->message->type = "error";
		$this->response->message->title = "Tipo de identificación";
		$this->response->message->message = "El Tipo de identificación no pudo ser suspendido con éxito";

		$data = [
			"id_action" => 'ac04'
		];

		if ($this->DocumentType_model->updated($data, $id)) {

			$this->response->message->type = "success";
			$this->response->message->message = "El Tipo de identificación fue suspendido con éxito";
		}
		echo json_encode($this->response);
	}

	public function active()
	{
		$id = $this->input->post('id');
		$this->response->message->type = "error";
		$this->response->message->title = "Tipo de identificación";
		$this->response->message->message = "El Tipo de identificación no pudo ser activado con éxito";


		$data = [
			"id_action" => 'ac01'
		];

		if ($this->DocumentType_model->updated($data, $id)) {
			$this->response->message->type = "success";
			$this->response->message->message = "El Tipo de identificación fue activado con éxito";
		}
		echo json_encode($this->response);
	}

	public function search()
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->DocumentType_model->search($search, $start, $limit);

		$table = $this->generateTable($getSearch);
		$this->response->data = $table;
		$this->response->message->type = "success";
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
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>" . htmlspecialchars_decode($row->name) . "</strong></td>
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
		$thead = ['N°', 'NOMBRE', 'ESTADO'];
		$tbody = $this->DocumentType_model->getAll();
		$data = [
			'title' => 'Tipos de identificación',
			'titleDocument' => 'Listado de los Tipos de identificación',
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
		$users = $this->DocumentType_model->getAll();
		$this->excelGenerate($header, $users, 'identification-types');
	}
}


/* End of file DocumentTypesController.php */
/* Location: ./application/controllers/DocumentTypesController.php */
