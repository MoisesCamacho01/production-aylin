<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class StatesController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("State_model");
		$this->load->model("Country_model");
	}

	public function index($submenu)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			// 'resources/librerias/leaflet/leaflet.js',
			'resources/src/js/states/states.js?t=6s',
			// 'resources/src/js/states/map.js?t=3s'
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Estados',
			'js' => $js,
			'countries' => $this->Country_model->getAll(),
			'url' => site_url('states/search'),
			'quantity' => count($this->State_model->getAll())
		];

		$this->page = 'app/admin/states/index';
		$this->layout();
	}

	public function getRegister($id)
	{
		$answer = $this->State_model->getForId($id);
		$this->response->message->type = 'error';
		$this->response->message->title = 'Provincia no encontrado';
		$this->response->message->message = 'La provincia no fue encontrado';

		if ($answer) {

			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'El Estado fue encontrado con éxito';
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();
		$this->setTable('states');
		$this->response->message->type = 'error';
		$this->response->message->title = 'Estado Creado';
		$this->response->message->message = 'El Estado no pudo ser creado con éxito';

		$name = htmlspecialchars($this->input->post('name'));
		$idCountries = htmlspecialchars($this->input->post('country'));

		$value = $validate->validate([
			["name" => "Nombre de la provincia", "type" => "string", "value" => $name, "min" => 1, "max" => 50, "required" => true],
			["name" => "El país", "type" => "string", "value" => $idCountries, "min" => 1, "max" => 191, "required" => true]
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {

			$data = [
				"id" => $this->generateId(),
				"name" => $name,
				"id_countries" => $idCountries,
				"id_actions" => 'ac01',
				"created_at" => date('Y-m-d H:i:s'),
				"updated_at" => date('Y-m-d H:i:s')
			];

			$this->response->message->title = "Estado Creado";
			$this->response->message->message = "El Estado no pudo ser creado con éxito";

			if ($this->State_model->insert($data)) {
				$this->response->message->type = "success";
				$this->response->message->message = "El Estado fue creado con éxito";

			}

		}

		echo json_encode($this->response);
	}

	public function update()
	{

		$validate = new ValidateController();
		$this->setTable('states');
		$this->setId($this->input->post('id'));

		$name = htmlspecialchars($this->input->post('name'));

		$value = $validate->validate([
			["name" => "nombre de usuario", "type" => "string", "value" => $name, "min" => 1, "max" => 50, "required" => true]
		]);

		if ($value->status) {
			$valueDuplicate = $this->duplicateUpdate([
				["attribute" => "name", "value" => $name, "message" => "El nombre de a provincia"]
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"name" => $name,
					"id_countries" => $this->input->post('country'),
					"id_actions" => 'ac02',
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->title = "Provincia Actualizado";
				$this->response->message->message = "La Provincia no pudo ser actualizada con éxito";

				if ($this->State_model->updated($data, $this->input->post('id'))) {
					$this->response->message->type = "success";
					$this->response->message->message = "La Provincia fue actualizada con éxito";
				}

			}
		}

		echo json_encode($this->response);
	}

	public function delete()
	{
		$id = $this->input->post('id');

		$this->response->message->type = "error";
		$this->response->message->title = "Provincia Eliminada";
		$this->response->message->message = "La Provincia no pudo ser eliminada con éxito";

		$data = [
			"id_actions" => 'ac03'
		];

		if ($this->State_model->updated($data, $id)) {
			$this->response->message->type = "success";
			$this->response->message->message = "La Provincia fue eliminada con éxito";

		}
		echo json_encode($this->response);
	}

	public function suspend()
	{
		$id = $this->input->post('id');
		$this->response->message->type = "error";
		$this->response->message->title = "Provincia Suspendida";
		$this->response->message->message = "La Provincia no pudo ser suspendida con éxito";

		$data = [
			"id_actions" => 'ac04'
		];

		if ($this->State_model->updated($data, $id)) {
			$this->response->message->type = "success";
			$this->response->message->message = "La Provincia fue suspendida con éxito";

		}
		echo json_encode($this->response);
	}
	public function active()
	{
		$id = $this->input->post('id');
		$this->response->message->type = "error";
		$this->response->message->title = "Provincia Activada";
		$this->response->message->message = "La Provincia no pudo ser activada con éxito";

		$data = [
			"id_actions" => 'ac01'
		];

		if ($this->State_model->updated($data, $id)) {
			$this->response->message->type = "success";
			$this->response->message->message = "La Provincia fue activada con éxito";
		}
		echo json_encode($this->response);
	}

	public function search()
	{
		$search = $this->input->post('search');
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->State_model->search($search, $start, $limit);
		$table = htmlspecialchars_decode($this->generateTable($getSearch));
		$this->response->data = $table;
		$this->response->message->type = "success";
		$this->response->message->title = "Registro Encontrado";
		$this->response->message->message = "El registro fue encontrado con éxito";
		echo json_encode($this->response);
	}
	public function drawMap()
	{
		$id = $this->input->post('id');

		$cords = json_decode($this->input->post('cords'));
		$this->response->message->type = 'error';
		$this->response->message->title = 'Dibujar provincia';
		$this->response->message->message = 'El mapa de la provincia no se pudo dibujar';

		if ($this->State_model->drawDelete($id)) {
			$poligono = "";
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

			if ($this->State_model->drawCreate($data)) {
				$this->response->message->type = 'success';
				$this->response->message->message = 'El mapa del canton fue dibujado con éxito';
			}
		}

		echo json_encode($this->response);
	}
	public function getDrawMap($idState)
	{
		$answer = $this->State_model->getForMapId($idState);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Buscar Mapa';
		$this->response->message->message = 'La Mapa de la provincia no fue encontrado';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'La Mapa de la provincia fue encontrado con éxito';
		}

		echo json_encode($this->response);
	}
	public function allSectorForCountry($idCountry)
	{
		$answer = $this->State_model->getAllPolygon($idCountry);

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
	public function allAlarmOfState($idState)
	{
		$answer = $this->State_model->getAllAlarmOfState($idState);

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
				<td>{$row->country}</td>
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
							$template .= "<a class='dropdown-item btnInputHidden btnDrawMap' data-bs-toggle='modal' data-bs-target='#dibujarModal' href='javascript:void(0);' dataId='{$row->id}' dataIdC='$row->id_countries'><i class='bx bxs-palette' ></i> $rowB->name provincia</a>";
						}

						if ($rowB->id == 'BP009') {
							$template .= "<a class='dropdown-item btnInputHidden btnGetDraw' data-bs-toggle='modal' data-bs-target='#viewMapModal' href='javascript:void(0);' dataId='{$row->id}' dataIdC='$row->id_countries'><i class='bx bx-low-vision' ></i> $rowB->name provincia</a>";
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
		$thead = ['N°', 'NOMBRE', 'PAIS', 'ESTADO'];
		$tbody = $this->State_model->getAll();
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
		$header = ['NOMBRE', 'NOMBRE', 'PAIS', 'ESTADO'];
		$users = $this->State_model->getAll();
		$this->excelGenerate($header, $users, 'states');
	}
}

/* End of file StatesController.php */
/* Location: ./application/controllers/StatesController.php */
