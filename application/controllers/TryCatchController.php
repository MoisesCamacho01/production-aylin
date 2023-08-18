<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TryCatchController extends CI_Controller{

	public $table = "";
	public function __construct(){
		parent::__construct();
		$this->load->model('TryCatch_model');
	}

	public function setTable($table){
		$this->table = $table;
	}
  public function duplicate($attributes = []){
		$array = json_decode(json_encode($attributes), true);
		$response = (object)[
			"message" => "correcto",
			"status" => true
		];

		foreach($array as $attribute){
			if($this->TryCatch_model->duplicate($this->table, $attribute['name'], $attribute['value'])){
				$response->message = "El registro ya esta duplicado";
				$response->status = false;
			}
		}

		return $response;
  }

}


/* End of file TryCatchController.php */
/* Location: ./application/controllers/TryCatchController.php */
