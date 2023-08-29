<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class DrawMapsController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Country_model');
		$this->load->model('State_model');
	}

	public function drawState($idCountry)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/librerias/leaflet/leaflet.js',
			// 'resources/src/js/states/states.js?t=6s',
			'resources/src/js/states/map.js?t=3s'
		];

		$this->data = [
			'title' => 'Dibujar Provincias',
			'js' => $js,
			'states' => $this->State_model->getAll($idCountry)
		];

		$this->page = 'app/admin/states/drawMap.php';
		$this->layout();
	}

}


/* End of file DrawMapsController.php */
/* Location: ./application/controllers/DrawMapsController.php */
