<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class SectorsController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sector_model');
		// $this->load->model('Distric_model');
		$this->load->model('Parish_model');
		$this->load->model('City_model');
	}

	public function index($submenu, $idDistric)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/sectors.js?t=6',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'SECTORES',
			'js' => $js,
			'distric' => $this->Parish_model->getForId($idDistric),
			'quantity' => count($this->Sector_model->getAll()),
			'url' => site_url('districs/' . $idDistric . '/search')
		];

		$this->page = 'app/admin/sectors/index';
		$this->layout();
	}

	public function sectorsView($submenu)
	{
		$js = [
			'resources/layout/assets/js/ui-modals.js',
			'resources/src/js/sectorsView.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Parroquias',
			'cities' => $this->City_model->getAll(),
			'submenu' => $submenu,
			'js' => $js,
		];

		$this->page = 'app/admin/sectors/sectorsView';
		$this->layout();
	}

	public function getRegister($idDistric, $idSector)
	{
		$answer = $this->Sector_model->getForId($idSector, $idDistric);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Sector encontrado';
		$this->response->message->message = 'El Sector no fue encontrado';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'El Sector fue encontrado';
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();

		$this->response->message->type = 'error';
		$this->response->message->title = 'Sector Creado';
		$this->response->message->message = 'El Sector no pudo ser creado con éxito';

		$name = htmlspecialchars($this->input->post('name'));
		$distric = htmlspecialchars($this->input->post('distric'));
		$color = htmlspecialchars($this->input->post('color'));

		$value  = $validate->validate([
			["name"=>"Nombre del sector", "type"=>"string", "value"=>$name, "min"=>1, "max"=>191, "required"=>true],
			["name"=>"El barrio", "type"=>"string", "value"=>$distric, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"El Color", "type"=>"string", "value"=>$color, "min"=>1, "max"=>20, "required"=>true]
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){

			$data = [
				"id" => $this->generateId(),
				"name" => $name,
				"color" => $color,
				"id_distric" => $distric,
				"id_actions" => 'ac01',
				"created_at" => date('Y-m-d H:i:s'),
				"updated_at" => date('Y-m-d H:i:s')
			];

			$this->response->message->type = 'error';
			$this->response->message->title = 'Sector Creado';
			$this->response->message->message = 'El Sector no pudo ser creado con éxito';

			if ($this->Sector_model->insert($data)) {
				$this->response->message->type = 'success';
				$this->response->message->message = 'El Sector pudo ser creado con éxito';
			}

			echo json_encode($this->response);
		}

	}

	public function update()
	{
		$validate = new ValidateController();

		$this->response->message->type = 'error';
		$this->response->message->title = 'Sector Actualizado';
		$this->response->message->message = 'El Sector no pudo ser actualizado con éxito';

		$name = htmlspecialchars($this->input->post('name'));
		$distric = htmlspecialchars($this->input->post('distric'));
		$color = htmlspecialchars($this->input->post('color'));

		$value  = $validate->validate([
			["name"=>"Nombre del sector", "type"=>"string", "value"=>$name, "min"=>1, "max"=>191, "required"=>true],
			["name"=>"El barrio", "type"=>"string", "value"=>$distric, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"El Color", "type"=>"string", "value"=>$color, "min"=>1, "max"=>20, "required"=>true]
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			$data = [
				"name" => $name,
				"color" => $color,
				"id_distric" => $distric,
				"id_actions" => 'ac02',
				"updated_at" => date('Y-m-d H:i:s')
			];

			$this->response->message->type = 'error';
			$this->response->message->title = 'Sector Actualizado';
			$this->response->message->message = 'El Sector no pudo ser actualizado con éxito';

			if ($this->Sector_model->updated($data, $this->input->post('id'))) {
				$this->response->message->type = 'success';
				$this->response->message->message = 'El Sector pudo ser actualizado con éxito';
			}
		}


		echo json_encode($this->response);
	}

	public function delete()
	{
		$id = $this->input->post('id');

		$this->response->message->type = 'error';
		$this->response->message->title = 'Sector eliminado';
		$this->response->message->message = 'El Sector no fue eliminado con éxito';

		$data = [
			"id_actions" => 'ac03'
		];

		if ($this->Sector_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'El Sector fue eliminado con éxito';
		}
		echo json_encode($this->response);
	}

	public function suspend()
	{
		$id = $this->input->post('id');

		$this->response->message->type = 'error';
		$this->response->message->title = 'Sector eliminado';
		$this->response->message->message = 'El Sector no pudo ser suspendido con éxito';

		$data = [
			"id_actions" => 'ac04'
		];

		if ($this->Sector_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'El Sector pudo ser suspendido con éxito';
		}

		echo json_encode($this->response);
	}

	public function active()
	{
		$id = $this->input->post('id');

		$this->response->message->type = 'error';
		$this->response->message->title = 'Sector Activado';
		$this->response->message->message = 'El Sector no pudo ser suspendido con éxito';

		$data = [
			"id_actions" => 'ac01'
		];

		if ($this->Sector_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'El Sector pudo ser activado con éxito';
		}
		echo json_encode($this->response);
	}

	public function search($idInstitution)
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');

		$getSearch = $this->Sector_model->search($search, $start, $limit, $idInstitution);

		$table = $this->generateTable($getSearch);
		$this->response->data = htmlspecialchars_decode($table);
		$this->response->message->type = 'success';
		$this->response->message->title = 'Sector Encontrado';
		$this->response->message->message = 'El Sector pudo ser encontrado con éxito';

		echo json_encode($this->response);
	}

	public function drawMapSector()
	{
		$id = $this->input->post('id');

		$cords = json_decode($this->input->post('cords'));
		$this->response->message->type = 'error';
		$this->response->message->title = 'Dibujar Sector';
		$this->response->message->message = 'El mapa del sector no se pudo dibujar';

		if ($this->Sector_model->drawDelete($id)) {
			$data = (object)[];
			$status = "";
			foreach ($cords as $row) {

				$data = (object)[
					"id" => $this->generateId(),
					"lat" => $row->lat,
					"lng" => $row->lng,
					"id_sector" => $id,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				if ($this->Sector_model->drawCreate($data)) {
					$status = "success";
				} else {
					$status = "";
					break;
				}
			}
		}

		if ($status == "success") {
			$this->response->message->type = 'success';
			$this->response->message->message = 'El mapa del sector fue dibujado con éxito';
		}

		echo json_encode($this->response);
	}

	public function getDrawMapSector($idSector)
	{
		$answer = $this->Sector_model->getForMapId($idSector);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Buscar Mapa';
		$this->response->message->message = 'La Mapa del sector no fue encontrado';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'La Mapa del sector fue encontrado con éxito';
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
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->distric}</strong></td>
				<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->id}</strong></td>
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

								if ($row->action == 'delete') {
									if($rowB->id == 'BP003'){
										$template .= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#activeModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-user-check me-1'></i> $rowB->name</a>";
									}
								} else {
									if($rowB->id == 'BP005'){
										$template .= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#deleteModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-trash me-1'></i> $rowB->name</a>";
									}

									if($rowB->id == 'BP008'){
										$template .= "<a class='dropdown-item btnInputHidden btnDrawMap' data-bs-toggle='modal' data-bs-target='#dibujarModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bxs-palette' ></i> $rowB->name sector</a>";
									}

									if($rowB->id == 'BP009'){
										$template .= "<a class='dropdown-item btnInputHidden btnGetDraw' data-bs-toggle='modal' data-bs-target='#viewMapModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-low-vision' ></i> $rowB->name sector</a>";
									}

									$submenu = (isset($rowB->id_submenu)) ? $rowB->id_submenu : $this->session->userdata('submenu');
									if($rowB->id == 'BP0015'){
										$template .= "<a class='dropdown-item' href='" . site_url($submenu.'/'.'alarms/' . $row->id) . "'><i class='bx bx-bell' ></i> $rowB->name</a>";
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

	public function pdf($id)
	{


		$thead = ['N°', 'NOMBRE', 'COLOR','PARROQUIA','ESTADO'];
		$tbody = ($id != 0) ? $this->Sector_model->getAll($id) : $this->Sector_model->getAll();

		$data = [
			'title' => 'barrios',
			'titleDocument' => 'Lista de barrios',
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
		$header = ['NOMBRE', 'COLOR', 'PARROQUIA', 'ESTADO'];
		$users = $this->Sector_model->getAll();
		$this->excelGenerate($header, $users, 'barrios');
	}

	public function all()
	{
		$answer = $this->Sector_model->getAll();

		$this->response->message->type = "error";
		$this->response->message->title = "Sectores encontrados";
		$this->response->message->message = "Los sectores no fueron encontrados";

		if($answer){
			$this->response->data = $answer;
			$this->response->message->type = "success";
			$this->response->message->message = "Los sectores fueron encontrados";
		}
		echo json_encode($this->response);
	}

	public function allSectorDistrict($idDistrict){
		$answer = $this->Sector_model->getAllSectorDistrict($idDistrict);

		$this->response->message->type = "error";
		$this->response->message->title = "Sectores encontrados";
		$this->response->message->message = "Los sectores no fueron encontrados";

		if($answer){
			$this->response->data = $answer;
			$this->response->message->type = "success";
			$this->response->message->message = "Los sectores fueron encontrados";
		}
		echo json_encode($this->response);
	}
}


/* End of file SectorController.php */
/* Location: ./application/controllers/SectorController.php */
