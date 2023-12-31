<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class AlarmsController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Alarm_model');
		$this->load->model('Sector_model');
		$this->load->model('Manager_model');
		$this->load->model("NotificationType_model");
	}

	public function index($submenu, $idSector)
	{
		$user = $this->session->userdata('usuario');

		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/librerias/select2/dist/js/select2.min.js',
			'resources/src/js/alarms.js?t=5',
			// 'resources/src/js/alarmsSound.js?t=2s',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'code' => $user->id,
			'userName' => $user->user_name,
			'managers' => $this->Manager_model->getAll(),
			'buttonNotifications' => $this->NotificationType_model->getAll(),
			'title' => 'Alarmas',
			'js' => $js,
			'sector' => $this->Sector_model->getForId($idSector),
			'quantity' => count($this->Alarm_model->getAll($idSector)),
			'url' => site_url('alarms/' . $idSector . '/search')
		];

		$this->page = 'app/admin/alarms/index';
		$this->layout();
	}

	public function getRegister($idSector, $idAlarm)
	{
		$answer = $this->Alarm_model->getForId($idAlarm, $idSector);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Alarma Encontrada';
		$this->response->message->message = 'La alarma no pudo ser encontrada con éxito';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'La alarma pudo ser encontrada con éxito';
		}

		echo json_encode($this->response);
	}

	public function create()
	{
		$validate = new ValidateController();
		$this->setTable('alarms');

		$this->response->message->type = 'error';
		$this->response->message->title = 'Alarma Creado';
		$this->response->message->message = 'La alarma no pudo ser creado con éxito';

		$code = htmlspecialchars($this->input->post('code'));
		$manager = htmlspecialchars($this->input->post('manager'));
		$sector = htmlspecialchars($this->input->post('sector'));
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');

		$value  = $validate->validate([
			["name"=>"El codigo", "type"=>"string", "value"=>$code, "min"=>1, "max"=>191, "required"=>true],
			["name"=>"El Encargado", "type"=>"string", "value"=>$manager, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"El Sector", "type"=>"string", "value"=>$sector, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"La latitud", "type"=>"string", "value"=>$latitude, "min"=>1, "max"=>22, "required"=>true],
			["name"=>"La longitud", "type"=>"string", "value"=>$longitude, "min"=>1, "max"=>22, "required"=>true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			$valueDuplicate = $this->duplicate([
				["attribute" => "code", "value" => $code, "message"=>"El código de la alarma"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = (object)[
					"id" => $this->generateId(),
					"code" => $code,
					"id_sector" => $sector,
					"latitude" => $latitude,
					"longitude" => $longitude,
					"id_alarm_manager" => $manager,
					"id_user" => 'U001',
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->type = 'error';
				$this->response->message->title = 'Alarma Creada';
				$this->response->message->message = 'La alarma no pudo ser creada con éxito';

				if ($this->Alarm_model->insert($data)) {
					$this->response->message->type = 'success';
					$this->response->message->message = 'La alarma pudo ser creada con éxito';
				}
			}
		}


		echo json_encode($this->response);
	}
	public function update()
	{
		$validate = new ValidateController();
		$this->setTable('alarms');
		$this->setId($this->input->post('id'));

		$this->response->message->type = 'error';
		$this->response->message->title = 'Alarma Creado';
		$this->response->message->message = 'La alarma no pudo ser creado con éxito';

		$code = htmlspecialchars($this->input->post('code'));
		$manager = htmlspecialchars($this->input->post('manager'));
		$sector = htmlspecialchars($this->input->post('sector'));
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');

		$value  = $validate->validate([
			["name"=>"El codigo", "type"=>"string", "value"=>$code, "min"=>1, "max"=>191, "required"=>true],
			["name"=>"El Encargado", "type"=>"string", "value"=>$manager, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"El Sector", "type"=>"string", "value"=>$sector, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"La latitud", "type"=>"string", "value"=>$latitude, "min"=>1, "max"=>22, "required"=>true],
			["name"=>"La longitud", "type"=>"string", "value"=>$longitude, "min"=>1, "max"=>22, "required"=>true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			$valueDuplicate = $this->duplicateUpdate([
				["attribute" => "code", "value" => $code, "message"=>"El codigo de la alarma"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {

				$data = (object)[
					"code" => $code,
					"id_sector" => $sector,
					"latitude" => $latitude,
					"longitude" => $longitude,
					"id_alarm_manager" => $manager,
					"id_user" => 'U001',
					"id_action" => 'ac02',
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->type = 'error';
				$this->response->message->title = 'Alarma Actualizada';
				$this->response->message->message = 'La alarma no pudo ser actualizada con éxito';

				if ($this->Alarm_model->updated($data, $this->input->post('id'))) {
					$this->response->message->type = 'success';
					$this->response->message->message = 'La alarma pudo ser actualizada con éxito';
				}
			}
		}


		echo json_encode($this->response);
	}
	public function delete()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = 'Alarma Eliminada';
		$this->response->message->message = 'La alarma no pudo ser Eliminada con éxito';

		$data = [
			"id_action" => 'ac03'
		];

		if ($this->Alarm_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'La alarma pudo ser eliminada con éxito';
		}
		echo json_encode($this->response);
	}
	public function suspend()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = 'Alarma Suspendida';
		$this->response->message->message = 'La alarma no pudo ser suspendida con éxito';

		$data = [
			"id_action" => 'ac04'
		];

		if ($this->Alarm_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'La alarma pudo ser suspendida con éxito';
		}
		echo json_encode($this->response);
	}
	public function active()
	{
		$id = $this->input->post('id');
		$this->response->message->type = 'error';
		$this->response->message->title = 'Alarma Activada';
		$this->response->message->message = 'La alarma no pudo ser activada con éxito';


		$data = [
			"id_action" => 'ac01'
		];

		if ($this->Alarm_model->updated($data, $id)) {
			$this->response->message->type = 'success';
			$this->response->message->message = 'La alarma pudo ser activada con éxito';
		}
		echo json_encode($this->response);
	}

	public function search($idInstitution)
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->Alarm_model->search($search, $start, $limit, $idInstitution);
		$table = htmlspecialchars_decode($this->generateTable($getSearch, $start));
		$quantity = $this->Alarm_model->search($search, $start, $limit, $idInstitution, true);
		$this->response->quantity = count($quantity);
		$this->response->data = $table;
		$this->response->message->type = 'success';
		$this->response->message->title = 'Registro Encontrado';
		$this->response->message->message = 'La alarma pudo ser creada con éxito';

		echo json_encode($this->response);
	}

	public function searchAlarm(){
		$code = htmlspecialchars($this->input->post('search'));

		$answer = $this->Alarm_model->searchAlarm($code);
		$this->response->message->type = 'error';
		$this->response->message->title = 'Registro no encontrado';
		$this->response->message->message = 'La alarma no pudo ser creada con éxito';

		if($answer){
			$this->response->quantity = count($answer);
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->title = 'Registro Encontrado';
			$this->response->message->message = 'La alarma pudo ser creada con éxito';
		}

		echo json_encode($this->response);
	}

	public function drawMapAlarm()
	{
		$id = $this->input->post('id');

		$cords = json_decode($this->input->post('cords'));
		$this->response->message->type = 'error';
		$this->response->message->title = 'Dibujar Alarma';
		$this->response->message->message = 'La alarma no se pudo dibujar';

		if ($this->Alarm_model->drawDelete($id)) {
			$poligono = "";
			if(isset($cords[0]->lng)){
				foreach ($cords as $row) {
					$poligono .= "$row->lng $row->lat,";
				}

				$poligono .= $cords[0]->lng . " " . $cords[0]->lat;

				$data = (object) [
					"id" => $this->generateId(),
					"geo" => $poligono,
					"id_alarm" => $id,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				if ($this->Alarm_model->drawCreate($data)) {
					$this->response->message->type = 'success';
					$this->response->message->message = 'El area de la alarma fue dibujado con éxito';
				}
			}else{
				$this->response->message->type = 'success';
				$this->response->message->message = 'El area de la alarma fue borrado con éxito';
			}

		}

		echo json_encode($this->response);
	}

	public function getDrawMapAlarm($idAlarm)
	{
		$answer = $this->Alarm_model->getForMapId($idAlarm);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Buscar Mapa';
		$this->response->message->message = 'El Mapa de la alarma no fue encontrado';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'El Mapa de la alarma fue encontrado';
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
				$i++;
				$template .= "<tr>
			  <td>{$i}</td>
			  <td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->code}</strong></td>
			  <td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->name_manager}</strong></td>
			  <td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->sector}</strong></td>
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
									$template .= "<a class='dropdown-item btnInputHidden btnDrawMap' data-bs-toggle='modal' data-bs-target='#dibujarModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bxs-palette' ></i> $rowB->name area de alarma</a>";
								}

								if($rowB->id == 'BP009'){
									$template .= "<a class='dropdown-item btnInputHidden btnGetDraw' data-bs-toggle='modal' data-bs-target='#viewMapModal' href='javascript:void(0);' dataId='{$row->id}'><i class='bx bx-low-vision' ></i> $rowB->name area de alarma</a>";
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

	public function pdf($idSector)
	{
		$thead = ['N°', 'NOMBRE', 'LATITUD', 'LONGITUD','ENCARGADO','SECTOR', 'ESTADO'];
		$tbody = ($idSector == 0) ? $this->Alarm_model->getAll() : $this->Alarm_model->getAll($idSector);

		$data = [
			'title' => 'Alarmas',
			'titleDocument' => 'Lista de alarmas',
			'thead' => $thead,
			'tbody' => $tbody
		];

		$mPdf = new \Mpdf\Mpdf();
		$document = $this->load->view('pdf/table.php', $data, true);
		$mPdf->WriteHTML($document);
		$mPdf->Output();
	}

	public function excel($idSector)
	{
		$header = ['NOMBRE', 'LATITUD', 'LONGITUD','ENCARGADO', 'SECTOR', 'ESTADO'];
		$users = ($idSector == 0) ? $this->Alarm_model->getAll() : $this->Alarm_model->getAll($idSector);
		$this->excelGenerate($header, $users, 'alarms');
	}

	public function allOfSector($idSector)
	{
		$answer = $this->Alarm_model->getAllPolygon($idSector);
		$this->response->message->type = "error";
		$this->response->message->title = "Alarmas encontradas";
		$this->response->message->message = "Las alarmas no fueron encontradas";

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = "success";
			$this->response->message->message = "Las alarmas fueron encontrados";
		}

		echo json_encode($this->response);
	}
}


/* End of file AlarmsController.php */
/* Location: ./application/controllers/AlarmsController.php */
