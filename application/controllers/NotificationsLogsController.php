<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class NotificationsLogsController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('NotificationLog_model');
	}

	public function index()
	{
		//
	}

	public function activeAlarm()
	{
		$user = $this->session->userdata('usuario');
		$validate = new ValidateController();

		$this->response->message->type = 'error';
		$this->response->message->title = 'Activación de alarma';
		$this->response->message->message = 'Las alarmas no se han podido activar';

		$id_sector = htmlspecialchars($this->input->post('sector'));
		$id_typeNot = htmlspecialchars($this->input->post('typeNot'));
		$ip = htmlspecialchars($this->input->post('ip'));
		$why = htmlspecialchars($this->input->post('why'));
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');

		$value  = $validate->validate([
			["name"=>"El sector", "type"=>"string", "value"=>$id_sector, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"El tipo de notificación", "type"=>"string", "value"=>$id_typeNot, "min"=>1, "max"=>255, "required"=>true],
			["name"=>"El motivo", "type"=>"string", "value"=>$why, "min"=>1, "max"=>2000, "required"=>true],
			["name"=>"La IP", "type"=>"string", "value"=>$ip, "min"=>1, "max"=>15, "required"=>true],
			["name"=>"La latitud", "type"=>"string", "value"=>$lat, "min"=>1, "max"=>22, "required"=>true],
			["name"=>"La longitud", "type"=>"string", "value"=>$lng, "min"=>1, "max"=>22, "required"=>true]
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if($value->status){
			$data = (object)[
				"id" => $this->generateId(),
				"why_activate" => $why,
				"lat" => $lat,
				"lng" => $lng,
				"ip" => $ip,
				"id_sector" => $id_sector,
				"id_user" => $user->id,
				"id_notification_type" => $id_typeNot,
				"id_action" => 'ac01',
				"created_at" => date('Y-m-d H:i:s'),
				"updated_at" => date('Y-m-d H:i:s')
			];

			$this->response->message->title = 'Activación de alarma';
			$this->response->message->message = 'Las alarmas no se han podido activar';

			if($this->NotificationLog_model->insert($data)){
				$this->response->message->type = 'success';
				$this->response->message->message = 'Las alarmas fueron activadas con éxito';
			}
		}

		echo json_encode($this->response);
	}
}


/* End of file NotificationsLogsController.php */
/* Location: ./application/controllers/NotificationsLogsController.php */
