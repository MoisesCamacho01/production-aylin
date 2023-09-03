<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class CitiesController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("City_model");
		$this->load->model("Country_model");
		$this->load->model("State_model");
	}

	public function index($submenu)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/cities/cities.js?t=2s',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Cantones',
			'js' => $js,
			'countries' => $this->Country_model->getAll(),
			'states' => $this->State_model->getAll(),
			'url' => site_url('cities/search'),
			'quantity' => count($this->City_model->getAll()),
		];

		$this->page = 'app/admin/cities/index';
		$this->layout();
	}

	public function citiesSearch($idState)
	{
		$answer = $this->City_model->getAll($idState);

		$this->response->message->type = "error";
		$this->response->message->title = "Cantones no encontradas";
		$this->response->message->message = "Los cantones no fueron encontradas";

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = "success";
			$this->response->message->message = "Los cantones fueron encontradas con éxito";
		}

		echo json_encode($this->response);
	}

	public function getRegister($id)
	{
		$answer = $this->City_model->getForId($id);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Catón encontrado';
		$this->response->message->message = 'Cantón no encontrado';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'Centón encontrado';
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();
		$this->setTable('cities');

		$this->response->message->type = 'error';
		$this->response->message->title = 'Cantón Creado';
		$this->response->message->message = 'El Cantón no pudo ser creado con éxito';

		$name = htmlspecialchars($this->input->post('name'));
		$states = htmlspecialchars($this->input->post('states'));

		$value = $validate->validate([
			["name" => "Nombre del cantón", "type" => "string", "value" => $name, "min" => 1, "max" => 50, "required" => true],
			["name" => "La provincia", "type" => "string", "value" => $states, "min" => 1, "max" => 50, "required" => true]
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {
			$valueDuplicate = $this->duplicate([
				["attribute" => "name", "value" => $name, "message" => "El nombre del cantón"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"id" => $this->generateId(),
					"name" => $name,
					"id_states" => $states,
					"id_actions" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->type = 'error';
				$this->response->message->title = 'Cantón Creado';
				$this->response->message->message = 'El cantón no pudo ser creado con éxito';

				if ($this->City_model->insert($data)) {
					$this->response->message->type = 'success';
					$this->response->message->message = 'El cantón fue creado con éxito';
				}
			}
		}

		echo json_encode($this->response);
	}

	public function update()
	{
		$validate = new ValidateController();
		$this->setTable('cities');
		$this->setId($this->input->post('id'));

		$this->response->message->type = 'error';
		$this->response->message->title = 'Cantón Creado';
		$this->response->message->message = 'El Cantón no pudo ser creado con éxito';

		$name = htmlspecialchars($this->input->post('name'));
		$states = htmlspecialchars($this->input->post('states'));

		$value = $validate->validate([
			["name" => "Nombre del cantón", "type" => "string", "value" => $name, "min" => 1, "max" => 50, "required" => true],
			["name" => "La provincia", "type" => "string", "value" => $states, "min" => 1, "max" => 50, "required" => true]
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {
			$valueDuplicate = $this->duplicateUpdate([
				["attribute" => "name", "value" => $name, "message" => "El nombre del cantón"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"name" => $this->input->post('name'),
					"id_states" => $this->input->post('states'),
					"id_actions" => 'ac02',
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->type = 'error';
				$this->response->message->title = 'Cantón Actualizado';
				$this->response->message->message = 'El cantón no pudo ser actualizado con éxito';

				if ($this->City_model->updated($data, $this->input->post('id'))) {
					$this->response->message->type = 'success';
					$this->response->message->message = 'El cantón fue actualizado con éxito';
				}
			}
		}

		echo json_encode($this->response);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = 'Cantón Eliminado';
		$this->response->message->message = 'El cantón no pudo ser eliminada con éxito';

		$data = [
			"id_actions" => 'ac03'
		];

		if ($this->City_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'El cantón fue eliminada con éxito';
		}
		echo json_encode($this->response);
	}

	public function suspend()
	{
		$id = $this->input->post('id');
		$response = [
			"message" => [
				"type" => "error",
				"title" => "Parroquia Suspendida",
				"message" => "La Parroquia no pudo ser suspendida"
			]
		];

		$data = [
			"id_actions" => 'ac04'
		];

		if ($this->City_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'El cantón fue suspendida con éxito';
		}
		echo json_encode($this->response);
	}

	public function active()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = 'Cantón Activado';
		$this->response->message->message = 'El cantón no pudo ser activada con éxito';

		$data = [
			"id_actions" => 'ac01'
		];

		if ($this->City_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'El cantón fue activada con éxito';
		}
		echo json_encode($this->response);
	}

	public function search()
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->City_model->search($search, $start, $limit);
		$table = htmlspecialchars_decode($this->generateTable($getSearch, $start));
		$quantity = $this->City_model->search($search, $start, $limit, false);
		$this->response->quantity = count($quantity);
		$this->response->data = $table;
		$this->response->message->type = 'success';
		$this->response->message->title = 'Registro Encontrado';
		$this->response->message->message = 'El registro fue encontrado con éxito';
		echo json_encode($this->response);
	}

	public function drawMap()
	{
		$id = $this->input->post('id');

		$cords = json_decode($this->input->post('cords'));
		$this->response->message->type = 'error';
		$this->response->message->title = 'Dibujar canton';
		$this->response->message->message = 'El mapa del canton no se pudo dibujar';
		if ($this->City_model->drawDelete($id)) {
			$poligono = "";
			if(isset($cords[0]->lng)){
				foreach ($cords as $row) {
					$poligono .= "$row->lng $row->lat,";
				}

				$poligono .= $cords[0]->lng . " " . $cords[0]->lat;

				$data = (object) [
					"id" => $this->generateId(),
					"geo" => $poligono,
					"id_city" => $id,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				if ($this->City_model->drawCreate($data)) {
					$this->response->message->type = 'success';
					$this->response->message->message = 'El mapa del canton fue dibujado con éxito';
				}
			}else{
				$this->response->message->type = 'success';
				$this->response->message->message = 'El mapa del canton fue borrado con éxito';
			}

		}

		echo json_encode($this->response);
	}

	public function getDrawMap($idState)
	{
		$answer = $this->City_model->getForMapId($idState);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Buscar Mapa';
		$this->response->message->message = 'La Mapa del canton no fue encontrado';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'La Mapa del canton fue encontrado con éxito';
		}

		echo json_encode($this->response);
	}

	public function allCityForState($idState)
	{
		$answer = $this->City_model->getAllPolygon($idState);

		$this->response->message->type = "error";
		$this->response->message->title = "Cantones encontradas";
		$this->response->message->message = "Los cantones no fueron encontrados";

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = "success";
			$this->response->message->message = "Los cantones fueron encontrados";
		}
		echo json_encode($this->response);
	}

	public function allAlarmOfCity($idCity)
	{
		$answer = $this->City_model->getAllAlarmOfCity($idCity);

		$this->response->message->type = "error";
		$this->response->message->title = "Provincias encontradas";
		$this->response->message->message = "Las provincias no fueron encontrados";

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = "success";
			$this->response->message->message = "Las provincias fueron encontrados";
		}
		echo json_encode($this->response);
	}

	public function generateTable($getRegisters, $page=1)
	{
		$template = '<tr><td><p>No se encontraron datos</p></td></tr>';
		if ($getRegisters) {
			$i = $page;
			$template = '';
			foreach ($getRegisters as $row) {
				if ($row->id_states == '12') {
					$i++;
					$template .= "<tr>
					<td>{$i}</td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->name}</strong></td>
					<td>{$row->states}</td>
					<td>";
					if ($row->action == 'create'):
						$template .= "<span class='badge bg-label-success me-1'>ACTIVO</span>";
					elseif ($row->action == 'suspend'):
						$template .= "<span class='badge bg-label-warning me-1'>SUSPENDIDO</span>";
					elseif ($row->action == 'edit'):
						$template .= "<span class='badge bg-label-primary me-1'>EDITADO</span>";
					elseif ($row->action == 'delete'):
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
					if ($this->buttonMenu($this->session->userdata('submenu'))) {
						foreach ($this->buttonMenu($this->session->userdata('submenu')) as $rowB) {
							if ($row->action == 'suspend') {
								if ($rowB->id == 'BP003') {
									$template .= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#activeModal' dataId='{$row->id}' href='javascript:void(0);'><i class='bx bx-user-check'></i> $rowB->name</a>";
								}
							} else {
								if ($rowB->id == 'BP002') {
									$template .= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#suspendModal' dataId='{$row->id}' href='javascript:void(0);'><i class='bx bx-user-x'></i> $rowB->name</a>";
								}
							}
							if ($rowB->id == 'BP004') {
								$template .= "<a class='dropdown-item btnInputHidden btnGetForId' dataId='{$row->id}' data-bs-toggle='modal' data-bs-target='#updateModal' href='javascript:void(0);'><i class='bx bx-edit-alt me-1'></i> $rowB->name</a>";
							}

							if ($rowB->id == 'BP008') {
								$template .= "<a class='dropdown-item btnInputHidden btnDrawMap' data-bs-toggle='modal' data-bs-target='#dibujarModal' href='javascript:void(0);' dataId='{$row->id}' dataIdC='$row->id_states'><i class='bx bxs-palette' ></i> $rowB->name cantón</a>";
							}

							if ($rowB->id == 'BP009') {
								$template .= "<a class='dropdown-item btnInputHidden btnGetDraw' data-bs-toggle='modal' data-bs-target='#viewMapModal' href='javascript:void(0);' dataId='{$row->id}' dataIdC='$row->id_states'><i class='bx bx-low-vision' ></i> $rowB->name cantón</a>";
							}

							if ($row->action == 'delete') {
								if ($rowB->id == 'BP003') {
									$template .= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#activeModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-user-check me-1'></i> $rowB->name</a>";
								}
							} else {
								if ($rowB->id == 'BP005') {
									$template .= "<a class='dropdown-item btnInputHidden' data-bs-toggle='modal' data-bs-target='#deleteModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-trash me-1'></i> $rowB->name</a>";
								}
							}
							$submenu = (isset($rowB->id_submenu)) ? $rowB->id_submenu : $this->session->userdata('submenu');
							if ($rowB->id == 'BP0012') {
								$template .= "<a class='dropdown-item' href='" . site_url($submenu . '/' . 'parishes/' . $row->id) . "'><i class='bx bx-church'></i> $rowB->name</a>";
							}
						}
						$template .= "<a class='dropdown-item' href='" . site_url('SM001/reports/maps?type=city&code='.$row->id) . "'><i class='bx bxs-map' ></i> Ver mapa</a>";
					}
					$template .= "
							</div>
						</div>
					</td>
				</tr>";
				}
			}
		}
		return $template;
	}

	public function pdf()
	{
		$thead = ['N°', 'NOMBRE', 'PROVINCIA', 'ESTADO'];
		$tbody = $this->City_model->getAll();

		$data = [
			'title' => 'Cantones',
			'titleDocument' => 'Lista de cantónes',
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
		$header = ['NOMBRE', 'PROVINCIA', 'ESTADO'];
		$users = $this->City_model->getAll();
		$this->excelGenerate($header, $users, 'cantones');
	}
}

/* End of file CitiesController.php */
/* Location: ./application/controllers/CitiesController.php */
