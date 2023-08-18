<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class ParishesController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Parish_model');
		$this->load->model('City_model');
	}

	public function index($submenu, $idCity)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/parishes.js?t=2',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Parroquias',
			'js' => $js,
			'cities' => $this->City_model->getForId($idCity),
			'quantity' => count($this->Parish_model->getAll($idCity)),
			'url' => site_url('parishes/'.$idCity.'/search')
		];

		$this->page = 'app/admin/parishes/index';
		$this->layout();
	}

	public function parishesSearch($idCity)
	{
		$answer = $this->Parish_model->getAll($idCity);

		$this->response->message->type = "error";
		$this->response->message->title = "Parroquias no encontradas";
		$this->response->message->message = "Las Parroquias no fueron encontradas";

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = "success";
			$this->response->message->message = "Las Parroquias fueron encontradas con éxito";
		}

		echo json_encode($this->response);
	}

	public function getRegister($idCity, $idBranch)
	{
		$answer = $this->Parish_model->getForId($idBranch, $idCity);

		$this->response->message->type = "error";
		$this->response->message->title = "Parroquia no encontrado";
		$this->response->message->message = "La Parroquia no fue encontrado";

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = "success";
			$this->response->message->message = "La Parroquia fue encontrada con éxito";
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();

		$this->response->message->type = "error";
		$this->response->message->title = "Parroquia creada";
		$this->response->message->message = "La Parroquia no pudo ser creado con éxito";

		$name = htmlspecialchars($this->input->post('name'));
		$idCity = htmlspecialchars($this->input->post('city'));

		$value  = $validate->validate([
			["name"=>"Nombre de la parroquia", "type"=>"string", "value"=>$name, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"La ciudad", "type"=>"string", "value"=>$idCity, "min"=>1, "max"=>255, "required"=>true]
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){

			$data = [
				"id" => $this->generateId(),
				"name" => $name,
				"id_city" => $idCity,
				"id_actions" => 'ac01',
				"created_at" => date('Y-m-d H:i:s'),
				"updated_at" => date('Y-m-d H:i:s')
			];

			$this->response->message->type = "error";
			$this->response->message->title = "Parroquia creada";
			$this->response->message->message = "La Parroquia no pudo ser creada con éxito";

			if ($this->Parish_model->insert($data)) {
				$this->response->message->type = "success";
				$this->response->message->message = "La Parroquia pudo ser creada con éxito";
			}
		}

		echo json_encode($this->response);
	}

	public function update()
	{
		$validate = new ValidateController();

		$this->response->message->type = "error";
		$this->response->message->title = "Parroquia Actualizada";
		$this->response->message->message = "La Parroquia no pudo ser actualizada con éxito";

		$name = htmlspecialchars($this->input->post('name'));
		$idCity = htmlspecialchars($this->input->post('city'));

		$value  = $validate->validate([
			["name"=>"Nombre de la parroquia", "type"=>"string", "value"=>$name, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"La ciudad", "type"=>"string", "value"=>$idCity, "min"=>1, "max"=>255, "required"=>true]
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			$data = [
				"name" => $this->input->post('name'),
				"id_city" => $this->input->post('city'),
				"id_actions" => 'ac02',
				"updated_at" => date('Y-m-d H:i:s')
			];

			$this->response->message->type = "error";
			$this->response->message->title = "Parroquia Actualizada";
			$this->response->message->message = "La Parroquia no pudo ser actualizada con éxito";

			if ($this->Parish_model->updated($data, $this->input->post('id'))) {
				$this->response->message->type = "success";
				$this->response->message->message = "La Parroquia pudo ser actualizada con éxito";
			}
		}

		echo json_encode($this->response);
	}

	public function delete()
	{
		$id = $this->input->post('id');

		$this->response->message->type = "error";
		$this->response->message->title = "Parroquia Eliminada";
		$this->response->message->message = "La Parroquia no pudo ser eliminada con éxito";

		$data = [
			"id_actions" => 'ac03'
		];

		if ($this->Parish_model->updated($data, $id)) {
			$this->response->message->type = "success";
			$this->response->message->message = "La Parroquia pudo ser eliminada con éxito";
		}

		echo json_encode($this->response);
	}

	public function suspend()
	{
		$id = $this->input->post('id');

		$this->response->message->type = "error";
		$this->response->message->title = "Parroquia Suspendida";
		$this->response->message->message = "La Parroquia no pudo ser suspendida con éxito";

		$data = [
			"id_actions" => 'ac04'
		];

		if ($this->Parish_model->updated($data, $id)) {
			$this->response->message->type = "error";
			$this->response->message->message = "La Parroquia pudo ser suspendida con éxito";
		}
		echo json_encode($this->response);
	}

	public function active()
	{
		$id = $this->input->post('id');

		$this->response->message->type = "error";
		$this->response->message->title = "Parroquia Activada";
		$this->response->message->message = "La Parroquia no pudo ser activa con éxito";

		$data = [
			"id_actions" => 'ac01'
		];

		if ($this->Parish_model->updated($data, $id)) {
			$this->response->message->type = "success";
			$this->response->message->message = "La Parroquia pudo ser activa con éxito";
		}
		echo json_encode($this->response);
	}

	public function search($idInstitution)
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->Parish_model->search($search, $start, $limit, $idInstitution);
		$table = htmlspecialchars_decode($this->generateTable($getSearch));

		$this->response->data = $table;
		$this->response->message->type = "success";
		$this->response->message->title = "Parroquia Encontrada";
		$this->response->message->message = "La Parroquia pudo ser encontrada con éxito";

		echo json_encode($this->response);
	}

	public function drawMap()
	{
		$id = $this->input->post('id');

		$cords = json_decode($this->input->post('cords'));
		$this->response->message->type = 'error';
		$this->response->message->title = 'Dibujar canton';
		$this->response->message->message = 'El mapa del canton no se pudo dibujar';

		if ($this->Parish_model->drawDelete($id)) {
			$data = (object)[];
			$status = "";
			foreach ($cords as $row) {

				$data = (object)[
					"id" => $this->generateId(),
					"lat" => $row->lat,
					"lng" => $row->lng,
					"id_state" => $id,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				if ($this->Parish_model->drawCreate($data)) {
					$status = "success";
				} else {
					$status = "";
					break;
				}
			}
		}

		if ($status == "success") {
			$this->response->message->type = 'success';
			$this->response->message->message = 'El mapa de la parroquia fue dibujado con éxito';
		}

		echo json_encode($this->response);
	}

	public function getDrawMap($idState)
	{
		$answer = $this->Parish_model->getForMapId($idState);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Buscar Mapa';
		$this->response->message->message = 'La Mapa de la parroquia no fue encontrado';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'La Mapa de la parroquia fue encontrado con éxito';
		}

		echo json_encode($this->response);
	}

	public function allParishForCity($idState){
		$answer = $this->Parish_model->getAll($idState);

		$this->response->message->type = "error";
		$this->response->message->title = "Parroquias encontradas";
		$this->response->message->message = "Las parroquias no fueron encontrados";

		if($answer){
			$this->response->data = $answer;
			$this->response->message->type = "success";
			$this->response->message->message = "Las parroquias fueron encontrados";
		}
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
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->city}</strong></td>
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

								if($rowB->id == 'BP008'){
									$template .= "<a class='dropdown-item btnInputHidden btnDrawMap' data-bs-toggle='modal' data-bs-target='#dibujarModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bxs-palette' ></i> $rowB->name parroquia</a>";
								}

								if($rowB->id == 'BP009'){
									$template .= "<a class='dropdown-item btnInputHidden btnGetDraw' data-bs-toggle='modal' data-bs-target='#viewMapModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-low-vision' ></i> $rowB->name parroquia</a>";
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
								if($rowB->id == 'BP0013'){
									$template .= "<a class='dropdown-item' href='".site_url($submenu.'/'.'districs/'.$row->id)."'><i class='bx bx-building' ></i> $rowB->name</a>";
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

	public function pdf($id_city)
	{
		$thead = ['N°', 'NOMBRE', 'CIUDAD','ESTADO'];
		$tbody = $this->Parish_model->getAll($id_city);

		$data = [
			'title' => 'Países',
			'titleDocument' => 'Lista de Parroquias',
			'thead' => $thead,
			'tbody' => $tbody
		];

		$mPdf = new \Mpdf\Mpdf();
		$document = $this->load->view('pdf/table.php', $data, true);
		$mPdf->WriteHTML($document);
		$mPdf->Output();
	}

	public function excel($id_city)
	{
		$header = ['NOMBRE', 'CIUDAD', 'ESTADO'];
		$users = $this->Parish_model->getAll($id_city);
		$this->excelGenerate($header, $users, 'parishes');
	}
}


/* End of file ParishesController.php */
/* Location: ./application/controllers/ParishesController.php */
