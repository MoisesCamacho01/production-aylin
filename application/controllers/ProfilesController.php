<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class ProfilesController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Profile_model");
	}

	public function getRegister($id)
	{
		$user = $this->session->userdata('usuario');
		$answer = $this->Profile_model->getProfilePorIdUser($id);

		$this->response->message->type = 'error';
		$this->response->message->title = 'Perfil de usuario';
		$this->response->message->message = 'Este usuario aun no tiene un perfil actualizado';

		if ($answer) {
			$this->response->data = $answer;
			$this->response->message->type = 'success';
			$this->response->message->message = 'El perfil de usuario fue encontrado';
		}

		echo json_encode($this->response);
	}

	public function updateProfile($idUser){
		$this->setTable('profile');
		$id = htmlspecialchars($idUser);
		$existRegister = $this->existRegister('id_user', $id);
		if($existRegister->status){
			$this->update($id);
		}else{
			$this->create($id);
		}
	}
	public function create($idUser)
	{
		$validate = new ValidateController();
		$this->setTable('profile');
		$this->response->message->type = 'error';
		$this->response->message->title = "Perfil Modificado";
		$this->response->message->message = "El perfil del usuario no pudo ser guardado";

		$name = htmlspecialchars($this->input->post('name'));
		$lastName = htmlspecialchars($this->input->post('lastName'));
		$country = htmlspecialchars($this->input->post('country'));
		$state = htmlspecialchars($this->input->post('state'));
		$city = htmlspecialchars($this->input->post('city'));
		$document_type = htmlspecialchars($this->input->post('documentType'));
		$document_number = htmlspecialchars($this->input->post('ci'));
		$address = htmlspecialchars($this->input->post('address'));
		$phone = htmlspecialchars($this->input->post('phone'));
		$mobile = htmlspecialchars($this->input->post('mobile'));
		$id_user = $idUser;

		$value = $validate->validate([
			["name" => "el usuario", "type" => "string", "value" => $id_user, "min" => 1, "max" => 255, "required" => true],
			["name" => "el nombre", "type" => "string", "value" => $name, "min" => 3, "max" => 50, "required" => true],
			["name" => "el apellido", "type" => "string", "value" => $lastName, "min" => 3, "max" => 50, "required" => true],
			["name" => "el país", "type" => "string", "value" => $country, "min" => 1, "max" => 255, "required" => true],
			["name" => "la provincia", "type" => "string", "value" => $state, "min" => 1, "max" => 255, "required" => true],
			["name" => "el canton", "type" => "string", "value" => $city, "min" => 1, "max" => 255, "required" => true],
			["name" => "el tipo de documento", "type" => "string", "value" => $document_type, "min" => 1, "max" => 255, "required" => true],
			["name" => "el número de documento", "type" => "number", "value" => $document_number, "min" => 1, "max" => 50, "required" => true],
			["name" => "el teléfono", "type" => "number", "value" => $phone, "min" => 0, "max" => 9, "required" => false],
			["name" => "el celular", "type" => "number", "value" => $mobile, "min" => 0, "max" => 10, "required" => false],
			["name" => "la dirección", "type" => "string", "value" => $address, "min" => 0, "max" => 500, "required" => true],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {
			$valueDuplicate = $this->duplicate([
				["attribute" => "document_number", "value" => $this->input->post('username'), "message" => "El documento"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"id" => $this->generateId(),
					"name" => $name,
					"last_name" => $lastName,
					"id_country" => $country,
					"id_state" => $state,
					"id_city" => $city,
					"id_document_type" => $document_type,
					"document_number" => $document_number,
					"address" => $address,
					"phone" => $phone,
					"mobile" => $mobile,
					"photo" => '',
					"id_user" => $id_user,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->title = "Perfil de usuario";
				$this->response->message->message = "El perfil de usuario no pudo ser guardado con éxito";

				if ($this->Profile_model->insert($data)) {
					$this->response->message->type = 'success';
					$this->response->message->message = "El perfil de usuario pudo ser guardado con éxito";
				}
			}
		}

		echo json_encode($this->response);
	}
	public function update($idUser)
	{
		$validate = new ValidateController();
		$this->setTable('profile');
		$this->response->message->type = 'error';
		$this->response->message->title = "Perfil Modificado";
		$this->response->message->message = "El perfil del usuario no pudo ser guardado";

		$name = htmlspecialchars($this->input->post('name'));
		$lastName = htmlspecialchars($this->input->post('lastName'));
		$country = htmlspecialchars($this->input->post('country'));
		$state = htmlspecialchars($this->input->post('state'));
		$city = htmlspecialchars($this->input->post('city'));
		$document_type = htmlspecialchars($this->input->post('documentType'));
		$document_number = htmlspecialchars($this->input->post('ci'));
		$address = htmlspecialchars($this->input->post('address'));
		$phone = htmlspecialchars($this->input->post('phone'));
		$mobile = htmlspecialchars($this->input->post('mobile'));
		$id_user = $idUser;

		$value = $validate->validate([
			["name" => "el usuario", "type" => "string", "value" => $id_user, "min" => 1, "max" => 255, "required" => true],
			["name" => "el nombre", "type" => "string", "value" => $name, "min" => 3, "max" => 50, "required" => true],
			["name" => "el apellido", "type" => "string", "value" => $lastName, "min" => 3, "max" => 50, "required" => true],
			["name" => "el país", "type" => "string", "value" => $country, "min" => 1, "max" => 255, "required" => true],
			["name" => "la provincia", "type" => "string", "value" => $state, "min" => 1, "max" => 255, "required" => true],
			["name" => "el canton", "type" => "string", "value" => $city, "min" => 1, "max" => 255, "required" => true],
			["name" => "el tipo de documento", "type" => "string", "value" => $document_type, "min" => 1, "max" => 255, "required" => true],
			["name" => "el número documento", "type" => "number", "value" => $document_number, "min" => 1, "max" => 50, "required" => true],
			["name" => "el teléfono", "type" => "number", "value" => $phone, "min" => 0, "max" => 9, "required" => false],
			["name" => "el celular", "type" => "number", "value" => $mobile, "min" => 0, "max" => 10, "required" => false],
			["name" => "la dirección", "type" => "string", "value" => $address, "min" => 0, "max" => 500, "required" => false],
		]);

		$this->response->message->title = "Tipo de datos";
		$this->response->message->message = $value->message;

		if ($value->status) {
			$valueDuplicate = $this->duplicateUpdate([
				["attribute" => "document_number", "value" => $this->input->post('username'), "message" => "El documento"],
			]);

			$this->response->message->message = $valueDuplicate->message;

			if ($valueDuplicate->status) {
				$data = [
					"name" => $name,
					"last_name" => $lastName,
					"id_country" => $country,
					"id_state" => $state,
					"id_city" => $city,
					"id_document_type" => $document_type,
					"document_number" => $document_number,
					"address" => $address,
					"phone" => $phone,
					"mobile" => $mobile,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				$this->response->message->title = "Perfil de usuario";
				$this->response->message->message = "El perfil de usuario no pudo ser guardado con éxito";

				if ($this->Profile_model->updated($data, $id_user)) {
					$this->response->message->type = 'success';
					$this->response->message->message = "El perfil de usuario pudo ser guardado con éxito";
				}
			}
		}

		echo json_encode($this->response);
	}

}


/* End of file UsersController.php */
/* Location: ./application/controllers/UsersController.php */
