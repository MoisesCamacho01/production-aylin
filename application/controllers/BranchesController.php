<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class BranchesController extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("Branch_model");
    $this->load->model("Institution_model");
    $this->load->model("Country_model");
    $this->load->model("State_model");
    $this->load->model("City_model");
  }

	public function index($submenu, $idInstitution){
		$js = [
			'resources/layout/assets/js/ui-modals.js',
			'resources/src/js/branches.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Branches',
			'js' => $js,
      	'institution'=>$this->Institution_model->getForId($idInstitution),
      	'countries'=>$this->Country_model->getAll(),
      	'states'=>$this->State_model->getAll(),
      	'cities'=>$this->City_model->getAll(),
			'url'=>site_url('branches/'.$idInstitution.'/search')
		];

		$this->page = 'app/admin/branches/index';
		$this->layout();
	}

	public function getRegister($idInstitution, $idBranch){
		$answer = $this->Branch_model->getForId($idInstitution, $idBranch);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Extensiones';
		$this->response->message->message = 'Los campus no fueron encontrados';

		if($answer){
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'Los campus fueron encontrados';
		}

		echo json_encode($this->response);

	}

	public function create(){
		$validate = new ValidateController();
		$this->setTable('branches');
		$this->response->message->type = 'error';
		$this->response->message->title = "Campus creado";
		$this->response->message->message = "El Campus no pudo ser creado con éxito";

		$name = htmlspecialchars($this->input->post('name'));
		$phone = htmlspecialchars($this->input->post('phone'));
		$mobile = htmlspecialchars($this->input->post('mobile'));
		$address = htmlspecialchars($this->input->post('address'));
		$id_institution = htmlspecialchars($this->input->post('institution'));
		$id_country = htmlspecialchars($this->input->post('country'));
		$id_states = htmlspecialchars($this->input->post('state'));
		$id_cities = htmlspecialchars($this->input->post('city'));

		$value = $validate->validate([
			["name" => "El nombre", "type" => "string", "value" => $name, "min" => 1, "max" => 500, "required" => true],
			["name" => "El teléfono", "type" => "email", "value" => $phone, "min" => 1, "max" => 9, "required" => true],
			["name" => "El celular", "type" => "string", "value" => $mobile, "min" => 6, "max" => 10, "required" => true],
			["name" => "La dirección", "type" => "string", "value" => $address, "min" => 1, "max" => 500, "required" => true],
			["name" => "La institución", "type" => "string", "value" => $id_institution, "min" => 1, "max" => 255, "required" => true],
			["name" => "El país", "type" => "string", "value" => $id_country, "min" => 1, "max" => 255, "required" => true],
			["name" => "La provincia", "type" => "string", "value" => $id_states, "min" => 1, "max" => 255, "required" => true],
			["name" => "La ciudad", "type" => "string", "value" => $id_cities, "min" => 1, "max" => 255, "required" => true],
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
					"address" => $address,
					"id_institution" => $id_institution,
					"id_country" => $id_country,
					"id_states" => $id_states,
					"id_cities" => $id_cities,
					"id_action"=>'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->title = "Campus creado";
				$this->response->message->message = "El Campus no pudo ser creado con éxito";

				if($this->Branch_model->insert($data)){

					$this->response->message->type = 'success';
					$this->response->message->message = "El Campus pudo ser creado con éxito";

				}
			}
		}

		echo json_encode($this->response);
	}

	public function update(){

		$validate = new ValidateController();
		$this->setTable('branches');
		$this->response->message->type = 'error';
		$this->response->message->title = "Campus creado";
		$this->response->message->message = "El Campus no pudo ser creado con éxito";

		$name = htmlspecialchars($this->input->post('name'));
		$phone = htmlspecialchars($this->input->post('phone'));
		$mobile = htmlspecialchars($this->input->post('mobile'));
		$address = htmlspecialchars($this->input->post('address'));
		$id_institution = htmlspecialchars($this->input->post('institution'));
		$id_country = htmlspecialchars($this->input->post('country'));
		$id_states = htmlspecialchars($this->input->post('state'));
		$id_cities = htmlspecialchars($this->input->post('city'));

		$value = $validate->validate([
			["name" => "El nombre", "type" => "string", "value" => $name, "min" => 1, "max" => 500, "required" => true],
			["name" => "El teléfono", "type" => "email", "value" => $phone, "min" => 1, "max" => 9, "required" => true],
			["name" => "El celular", "type" => "string", "value" => $mobile, "min" => 6, "max" => 10, "required" => true],
			["name" => "La dirección", "type" => "string", "value" => $address, "min" => 1, "max" => 500, "required" => true],
			["name" => "La institución", "type" => "string", "value" => $id_institution, "min" => 1, "max" => 255, "required" => true],
			["name" => "El país", "type" => "string", "value" => $id_country, "min" => 1, "max" => 255, "required" => true],
			["name" => "La provincia", "type" => "string", "value" => $id_states, "min" => 1, "max" => 255, "required" => true],
			["name" => "La ciudad", "type" => "string", "value" => $id_cities, "min" => 1, "max" => 255, "required" => true],
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
					"address" => $address,
					"id_institution" => $id_institution,
					"id_country" => $id_country,
					"id_states" => $id_states,
					"id_cities" => $id_cities,
					"id_action"=>'ac02',
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->title = "Campus actualizado";
				$this->response->message->message = "El Campus no pudo ser actualizado con éxito";

				if($this->Branch_model->updated($data, $this->input->post('id'))){
					$this->response->message->type = 'success';
					$this->response->message->message = "El Campus pudo ser actualizado con éxito";
				}
			}
		}

		echo json_encode($this->response);
	}

	public function delete(){
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Campus eliminado";
		$this->response->message->message = "El Campus no pudo ser eliminado con éxito";

		$data = [
			"id_action"=>'ac03'
		];

		if($this->Branch_model->updated($data, $id)){
			$this->response->message->type = 'success';
			$this->response->message->message = "El Campus pudo ser eliminado con éxito";
		}
		echo json_encode($this->response);
	}

	public function suspend(){
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Campus suspendido";
		$this->response->message->message = "El Campus no pudo ser suspendido con éxito";

		$data = [
			"id_action"=>'ac04'
		];

		if($this->Branch_model->updated($data, $id)){
			$this->response->message->type = 'success';
			$this->response->message->message = "El Campus pudo ser suspendido con éxito";
		}
		echo json_encode($this->response);
	}

	public function active(){
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = "Campus activado";
		$this->response->message->message = "El Campus no pudo ser activado con éxito";

		$data = [
			"id_action"=>'ac01'
		];

		if($this->Branch_model->updated($data, $id)){
			$this->response->message->type = 'error';
			$this->response->message->message = "El Campus pudo ser activado con éxito";

		}
		echo json_encode($this->response);
	}

	public function search($idInstitution){
		$search = $this->input->post('search');
		$getSearch = $this->Branch_model->search($search, $idInstitution);
		$table = $this->generateTable($getSearch);
		$this->response->data = $table;
		$this->response->message->type = 'success';
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
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->name}</strong></td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->address}</strong></td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->phone}</strong></td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->mobile}</strong></td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->institution}</strong></td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->country}</strong></td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->state}</strong></td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->city}</strong></td>
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
		$thead = ['N°', 'NOMBRE', 'TELÉFONO', 'CELULAR', 'DIRECCIÓN', 'INSTITUCIÓN', 'PAÍS', 'CIUDAD', 'ESTADO'];
		$tbody = $this->Branch_model->getAll();
		$data = [
			'title' => 'Campus',
			'titleDocument' => 'Lista de campus',
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
		$header = ['NOMBRE', 'TELÉFONO', 'CELULAR', 'DIRECCIÓN', 'INSTITUCIÓN', 'PAÍS', 'CIUDAD', 'ESTADO'];
		$users = $this->Branch_model->getAll();
		$this->excelGenerate($header, $users, 'campus');
	}
}


/* End of file Branches.php */
/* Location: ./application/controllers/Branches.php */
