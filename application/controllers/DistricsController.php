<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class DistricsController extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
	 $this->load->model('Parish_model');
	 $this->load->model('Distric_model');
	 $this->load->model('City_model');
  }

  public function index($submenu, $idParish)
	{
		$js = [
			'resources/layout/assets/js/ui-modals.js',
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/districs.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'BARRIOS',
			'js' => $js,
			'parish' => $this->Parish_model->getForId($idParish),
			'quantity' => count($this->Distric_model->getAll($idParish)),
			'url' => site_url('districs/'.$idParish.'/search')
		];

		$this->page = 'app/admin/districs/index';
		$this->layout();
	}

	public function districsView($submenu)
	{
		$js = [
			'resources/layout/assets/js/ui-modals.js',
			'resources/src/js/districsView.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Parroquias',
			'cities' => $this->City_model->getAll(),
			'submenu' => $submenu,
			'js' => $js,
		];

		$this->page = 'app/admin/districs/districsView';
		$this->layout();
	}

	public function districsSearch($idParish)
	{
		$answer = $this->Distric_model->getAll($idParish);

		$this->response->message->type = "error";
		$this->response->message->title = "Barrios no encontradas";
		$this->response->message->message = "Los Barrios no fueron encontradas";

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = "success";
			$this->response->message->message = "Los Barrios fueron encontradas con éxito";
		}

		echo json_encode($this->response);
	}

	public function getRegister($idParish, $idDistric)
	{
		$answer = $this->Distric_model->getForId($idDistric, $idParish);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Barrio encontrado';
		$this->response->message->message = 'El Barrio no fue encontrado';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->title = 'Barrio encontrado';
			$this->response->message->message = 'El Barrio fue encontrado';
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();

		$this->response->message->type = 'error';
		$this->response->message->title = 'Barrio Creado';
		$this->response->message->message = 'El Barrio no pudo ser creado con éxito';

		$name = htmlspecialchars($this->input->post('name'));
		$parish = htmlspecialchars($this->input->post('parish'));

		$value  = $validate->validate([
			["name"=>"Nombre el barrio", "type"=>"string", "value"=>$name, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"La parroquia", "type"=>"string", "value"=>$parish, "min"=>1, "max"=>255, "required"=>true]
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value){
			$data = [
				"id" => $this->generateId(),
				"name" => $name,
				"id_parish" => $parish,
				"id_actions" => 'ac01',
				"created_at" => date('Y-m-d H:i:s'),
				"updated_at" => date('Y-m-d H:i:s')
			];

			$this->response->message->type = 'error';
			$this->response->message->title = 'Barrio Creado';
			$this->response->message->message = 'El Barrio no pudo ser creado con éxito';

			if ($this->Distric_model->insert($data)) {
				$this->response->message->type = 'success';
				$this->response->message->message = 'El Barrio pudo ser creado con éxito';
			}
		}

		echo json_encode($this->response);
	}

	public function update()
	{
		$validate = new ValidateController();

		$this->response->message->type = 'error';
		$this->response->message->title = 'Barrio Creado';
		$this->response->message->message = 'El Barrio no pudo ser actualizado con éxito';

		$name = htmlspecialchars($this->input->post('name'));
		$parish = htmlspecialchars($this->input->post('parish'));

		$value  = $validate->validate([
			["name"=>"Nombre el barrio", "type"=>"string", "value"=>$name, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"La parroquia", "type"=>"string", "value"=>$parish, "min"=>1, "max"=>255, "required"=>true]
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value){
			$data = [
				"name" => $name,
				"id_parish" => $parish,
				"id_actions" => 'ac02',
				"updated_at" => date('Y-m-d H:i:s')
			];

			$this->response->message->type = 'error';
			$this->response->message->title = 'Barrio Creado';
			$this->response->message->message = 'El Barrio no pudo ser actualizado con éxito';

			if ($this->Distric_model->updated($data, $this->input->post('id'))) {
				$this->response->message->type = 'success';
				$this->response->message->message = 'El Barrio pudo ser actualizado con éxito';
			}
		}


		echo json_encode($this->response);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = 'Barrio Eliminado';
		$this->response->message->message = 'El Barrio no pudo ser eliminado con éxito';

		$data = [
			"id_actions" => 'ac03'
		];

		if ($this->Distric_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'El Barrio pudo ser eliminado con éxito';
		}
		echo json_encode($this->response);
	}

	public function suspend()
	{
		$id = $this->input->post('id');

		$this->response->message->type = 'error';
		$this->response->message->title = 'Barrio Suspendido';
		$this->response->message->message = 'El Barrio no pudo ser suspendido con éxito';

		$data = [
			"id_actions" => 'ac04'
		];

		if ($this->Distric_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'El Barrio pudo ser suspendido con éxito';
		}
		echo json_encode($this->response);
	}

	public function active()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = 'Barrio Activado';
		$this->response->message->message = 'El Barrio no pudo ser activado con éxito';

		$data = [
			"id_actions" => 'ac01'
		];

		if ($this->Distric_model->updated($data, $id)) {
			$this->response->message->type = 'error';
			$this->response->message->message = 'El Barrio pudo ser activado con éxito';
		}
		echo json_encode($this->response);
	}

	public function search($idInstitution)
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->Distric_model->search($search, $start, $limit, $idInstitution);
		$table = htmlspecialchars_decode($this->generateTable($getSearch));

		$this->response->data = $table;
		$this->response->message->type = 'success';
		$this->response->message->title = 'Registro Encontrado';
		$this->response->message->message = 'El Barrio pudo ser encontrado con éxito';

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
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->parish}</strong></td>
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
								if($rowB->id == 'BP0014'){
									$template .= "<a class='dropdown-item' href='".site_url($submenu.'/'.'sectors/'.$row->id)."'><i class='bx bx-building-house' ></i> $rowB->name</a>";
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

	public function pdf($id)
	{
		$thead = ['N°', 'NOMBRE', 'PARROQUIA','ESTADO'];
		$tbody = $this->Distric_model->getAll($id);

		$data = [
			'title' => 'Barrios',
			'titleDocument' => 'Lista de Barrios',
			'thead' => $thead,
			'tbody' => $tbody
		];

		$mPdf = new \Mpdf\Mpdf();
		$document = $this->load->view('pdf/table.php', $data, true);
		$mPdf->WriteHTML($document);
		$mPdf->Output();
	}

	public function excel($id)
	{
		$header = ['NOMBRE', 'PARROQUIA', 'ESTADO'];
		$users = $this->Distric_model->getAll($id);
		$this->excelGenerate($header, $users, 'districts');
	}
}


/* End of file DistricsController.php */
/* Location: ./application/controllers/DistricsController.php */
