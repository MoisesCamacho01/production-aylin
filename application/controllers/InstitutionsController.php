<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class InstitutionsController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Country_model');
		$this->load->model('Institution_model');
	}

	public function index($submenu)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/institutions.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Countries',
			'js' => $js,
			'countries' => $this->Country_model->getAll(),
			'url' => site_url('institutions/search'),
			'quantity' => count($this->Institution_model->getAll())
		];

		$this->page = 'app/admin/institutions/index';
		$this->layout();
	}

	public function getRegister($id)
	{
		$answer = $this->Institution_model->getForId($id);
		$this->response->message->type = 'error';
		$this->response->message->title = 'Institución';
		$this->response->message->message = 'La Institución no fue encontrada';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->success = 'success';
			$this->response->message->message = 'La Institución no fue encontrada';
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();
		$this->setTable('institutions');
		$this->response->message->type = 'error';
		$this->response->message->title = "Institución creada";
		$this->response->message->message = "La institución no pudo ser creado con éxito";

		$name = htmlspecialchars($this->input->post('name'));
		$phone = htmlspecialchars($this->input->post('phone'));
		$mobile = htmlspecialchars($this->input->post('mobile'));
		$country = htmlspecialchars($this->input->post('country'));

		$value = $validate->validate([
			["name" => "El nombre", "type" => "string", "value" => $name, "min" => 1, "max" => 300, "required" => true],
			["name" => "El Teléfono", "type" => "email", "value" => $phone, "min" => 1, "max" => 9, "required" => true],
			["name" => "El Celular", "type" => "string", "value" => $mobile, "min" => 6, "max" => 10, "required" => true],
			["name" => "El país", "type" => "string", "value" => $country, "min" => 1, "max" => 255, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {
			$valueDuplicate = $this->duplicate([
				["attribute" => "name", "value" => $name, "message"=>"El nombre del país"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"id" => $this->generateId(),
					"name" => $name,
					"phone" => $phone,
					"mobile" => $mobile,
					"id_country" => $country,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->title = "Institución creada";
				$this->response->message->message = "La institución no pudo ser creado con éxito";

				if ($this->Institution_model->insert($data)) {
					$this->response->message->type = 'success';
					$this->response->message->message = "La institución pudo ser creado con éxito";
				}
			}
		}


		echo json_encode($this->response);
	}

	public function update()
	{

		$validate = new ValidateController();
		$this->setTable('institutions');
		$this->response->message->type = 'error';
		$this->response->message->title = "Institución actualizada";
		$this->response->message->message = "La institución no pudo ser actualizada con éxito";

		$name = htmlspecialchars($this->input->post('name'));
		$phone = htmlspecialchars($this->input->post('phone'));
		$mobile = htmlspecialchars($this->input->post('mobile'));
		$country = htmlspecialchars($this->input->post('country'));

		$value = $validate->validate([
			["name" => "El nombre", "type" => "string", "value" => $name, "min" => 1, "max" => 300, "required" => true],
			["name" => "El Teléfono", "type" => "email", "value" => $phone, "min" => 1, "max" => 9, "required" => true],
			["name" => "El Celular", "type" => "string", "value" => $mobile, "min" => 6, "max" => 10, "required" => true],
			["name" => "El país", "type" => "string", "value" => $country, "min" => 1, "max" => 255, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {
			$valueDuplicate = $this->duplicateUpdate([
				["attribute" => "name", "value" => $name, "message"=>"El nombre del país"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"name" => $name,
					"phone" => $phone,
					"mobile" => $mobile,
					"id_country" => $country,
					"id_action" => 'ac02',
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->title = "Institución actualizada";
				$this->response->message->message = "La institución no pudo ser actualizada con éxito";

				if ($this->Institution_model->updated($data, $this->input->post('id'))) {
					$this->response->message->type = "success";
					$this->response->message->message = "La institución pudo ser actualizada con éxito";
				}
			}
		}

		echo json_encode($this->response);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Institución eliminada";
		$this->response->message->message = "La institución no pudo ser eliminada con éxito";

		$data = [
			"id_action" => 'ac03'
		];

		if ($this->Institution_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = "La institución pudo ser eliminada con éxito";
		}
		echo json_encode($this->response);
	}

	public function suspend()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Institución suspendida";
		$this->response->message->message = "La institución no pudo ser suspendida con éxito";

		$data = [
			"id_action" => 'ac04'
		];

		if ($this->Institution_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = "La institución pudo ser suspendida con éxito";
		}
		echo json_encode($this->response);
	}

	public function active()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Institución activada";
		$this->response->message->message = "La institución no pudo ser activada con éxito";

		$data = [
			"id_action" => 'ac01'
		];

		if ($this->Institution_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->title = "Institución activada";
			$this->response->message->message = "La institución pudo ser activada con éxito";
		}
		echo json_encode($this->response);
	}

	public function search()
	{
		$search = $this->input->post('search');
		$getSearch = $this->Institution_model->search($search);
		$table = $this->generateTable($getSearch);
		$this->response->data = $table;
		$this->response->message->type = 'success';
		$this->response->message->title = "Registro encontrado";
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
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->name}</strong></td>
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->phone}</strong></td>
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->mobile}</strong></td>
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->country}</strong></td>
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
								$submenu = (isset($rowB->id_submenu)) ? $rowB->id_submenu : $this->session->userdata('submenu');
								if($rowB->id == 'BP0016'){
									$template .= "<a class='dropdown-item' href='".site_url($submenu.'/'.'branches/'.$row->id)."'><i class='bx bx-git-branch'></i> $rowB->name</a>";
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
		$thead = ['N°', 'NOMBRE', 'TELEFONO', 'CELULAR', 'PAIS', 'ESTADO'];
		$tbody = $this->Institution_model->getAll();
		$data = [
			'title' => 'Instituciones',
			'titleDocument' => 'Lista de instituciones',
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
		$header = ['NOMBRE', 'TELEFONO', 'CELULAR', 'PAIS', 'ESTADO'];
		$users = $this->Institution_model->getAll();
		$this->excelGenerate($header, $users, 'institution');
	}
}


/* End of file InstitutionsController.php */
/* Location: ./application/controllers/InstitutionsController.php */
