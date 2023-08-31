<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("User_model");
		$this->load->model("Sector_model");
		$this->load->model("Alarm_model");
		$this->load->model("Parish_model");
		$this->load->model("Dashboard_model");
		$this->load->model("TypeNotification_model");

	}

	public function index()
	{
		$this->load->library('session');

		$js = [
			'resources/layout/assets/vendor/libs/apex-charts/apexcharts.js',
			'resources/layout/assets/vendor/libs/chartjs/chartjs.js',
			'resources/layout/assets/js/dashboards-analytics.js?t=5',
			'resources/layout/assets/js/dashboard-chartjs.js?t=5',

		];
		$this->data=[
			'title'=>'Dashboard',
			'typesNotification' => $this->TypeNotification_model->getAll(),
			'seguimientoActivacionAlarmas' => json_encode($this->Dashboard_model->getSeguimientoActivacionAlarma('todos')),
			'comparativaNotificacionAlarmas' => json_encode($this->Dashboard_model->getSeguimientoActivacionAlarma('todos')),
			'totalMotiveAlarm' => json_encode($this->Dashboard_model->getTotalMotiveAlarm()),
			'dataUser'=> $this->session->userdata('usuario'),
			'sectors'=> count($this->Sector_model->getAll()),
			'alarms'=> count($this->Alarm_model->getAll()),
			'alarmsActive'=> count($this->Dashboard_model->getAlarmActive()),
			'alarmsSuspend'=> count($this->Dashboard_model->getAlarmSuspend()),
			'users'=> count($this->User_model->getAllAdmin()),
			// 'usersMovil'=> count($this->User_model->getAllMovil()),
			'parishes'=> count($this->Parish_model->getAll()),
			'historyNotifications'=> $this->Dashboard_model->historyNotifications(),
			'js'=>$js,
		];

		$this->page = 'app/admin/dashboard/index';
		$this->layout();

	}

	public function kpi8($tipo){
		$answer = json_encode($this->Dashboard_model->getSeguimientoActivacionAlarma($tipo));
		if($answer){
			$this->response->message->type = 'success';
			$this->response->data = $answer;
		}
		echo json_encode($this->response);
	}
}


/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
