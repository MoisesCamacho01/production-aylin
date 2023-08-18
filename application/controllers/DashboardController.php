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

	}

	public function index()
	{
		$this->load->library('session');

		$js = [
			'resources/layout/assets/vendor/libs/apex-charts/apexcharts.js',
			'resources/layout/assets/js/dashboards-analytics.js?t=4',

		];
		$this->data=[
			'title'=>'Dashboard',
			'dataUser'=> $this->session->userdata('usuario'),
			'sectors'=> count($this->Sector_model->getAll()),
			'alarms'=> count($this->Alarm_model->getAll()),
			'alarmsActive'=> count($this->Dashboard_model->getAlarmActive()),
			'alarmsSuspend'=> count($this->Dashboard_model->getAlarmSuspend()),
			'users'=> count($this->User_model->getAll()),
			'parishes'=> count($this->Parish_model->getAll()),
			'historyNotifications'=> $this->Dashboard_model->historyNotifications(),
			'js'=>$js,
		];

		$this->page = 'app/admin/dashboard/index';
		$this->layout();

	}
}


/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
