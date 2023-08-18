<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class AuthController extends MY_Controller{

	// definiendo el constructor de la clase
	public function __construct(){
		parent::__construct();
		//llamando al modelo
		$this->load->model("User_model");
		$this->load->model('Profile_model');
		$this->load->model('User_type_model');
		$this->load->model('RegisterLog_model');
	}

	public function login(){
		$js = [
			'resources/src/js/login.js?t=4'
		];

		$data=[
			'title'=>'Login',
			'js'=>$js
		];

		$this->load->view('layout/auth/header', $data);
		$this->load->view('app/auth/login');
		$this->load->view('layout/auth/footer');
	}

	public function forgotPassword(){
		$js =[
			'resources/src/js/forgotPassword.js'
		];

		$data=[
			'title'=>'Recuperar Contraseña',
			'js'=>$js
		];

		$this->load->view('layout/auth/header', $data);
		$this->load->view('app/auth/forgotPassword');
		$this->load->view('layout/auth/footer');
	}

	public function startSession()
	{
		$email = htmlspecialchars($this->input->post('email'));
		$password = htmlspecialchars($this->input->post('password'));
		$answer = $this->User_model->startSession($email, $password);
		$this->response->message->type= 'success';
		$this->response->message->title= 'Inicio de sesión';
		$this->response->message->message= 'El inicio de sesión fue correcto';

		if ($answer) {
			$data = (object)[
				"id" => $this->generateId(),
				"email" => $email,
				"token" => $this->generateId(),
				"ip" => htmlspecialchars($this->input->post('ip')),
				"created_at" => date('Y-m-d H:i:s'),
				"updated_at" => date('Y-m-d H:i:s')
			];
			if($this->RegisterLog_model->systemAcceso($data)){
				unset($answer->password);
				$this->session->set_userdata('usuario', $answer);
			}
		} else {
			$this->response->message->type= 'error';
			$this->response->message->message= 'El inicio de sesión no se pudo realizar';
		}
		echo json_encode($this->response);
	}

	public function closeSession()
	{
		$this->session->sess_destroy();
		$this->response->message->type= 'success';
		$this->response->message->title= 'Cierre de session';
		$this->response->message->message= 'Sesión cerrada';
		echo json_encode($this->response);
	}

	public function sendEmailResetPassword(){
		$email = htmlspecialchars($this->input->post('email'));
		$this->setTable('users');

		$this->response->message->type = 'error';
		$this->response->message->title = 'Cambio de contraseña';
		$this->response->message->message = "El correo electrónico no coincide con ninguna cuenta registrada";

		$existEmail = $this->existRegister('email', $email);

		if($existEmail->status){

			$this->response->message->message = 'Ocurrió un problema con tu correo electrónico';

			$token = $this->generateId();

			$data = [
				"token" => $token,
			];

			$message = $this->load->view('email/tokenUpdatePassword', $data, true);

			if($this->sendEmail($email, $this->response->message->title, $message)){

				// insert log resetPassword
				$data = (object)[
					"id" => $this->generateId(),
					"email" => $email,
					"token" => $token,
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];

				if($this->RegisterLog_model->passwordReset($data)){
					$this->response->message->type = 'success';
					$this->response->message->message = 'Tu solicitud se ha enviado con éxito, revisa tu correo electrónico';
				}
			}
		}

		echo json_encode($this->response);
	}

	public function resetPassword($token){
		$this->setTable('password_resets');
		$existToken = $this->existRegister("status != 'activado' AND token = ", $token);

		if($existToken->status){
			$js = [
				'resources/src/js/resetPassword.js?t=4'
			];

			$data = [
				"js" => $js,
				"token"=>$token,
				"heading"=>"",
				"message"=>"hola"
			];
			$this->load->view('layout/auth/header', $data);
			$this->load->view('app/auth/updatePassword');
			$this->load->view('layout/auth/footer');
		}else{

			// $this->load->view('errors/pages/404');
			redirect('404');
		}
	}

	public function updatePassword(){
		$validate = new ValidateController();
		$this->setTable('users');

		$email = htmlspecialchars($this->input->post('email'));
		$password = htmlspecialchars($this->input->post('password'));
		$password2 = htmlspecialchars($this->input->post('password2'));
		$token = htmlspecialchars($this->input->post('token'));

		$existEmail = $this->existRegister('email', $email);

		$this->response->message->type = "error";
		$this->response->message->title = "Correo electrónico";
		$this->response->message->message = "El correo electrónico no coincide con ninguna cuenta registrada";

		if($existEmail->status){

			$value = $validate->validate([
				["name" => "el correo", "type" => "email", "value" => $email, "min" => 1, "max" => 255, "required" => true],
				["name" => "la contraseña", "type" => "string", "value" => $password, "min" => 6, "max" => 18, "required" => true],
				["name" => "la validación de contraseña", "type" => "string", "value" => $password2, "min" => 6, "max" => 18, "required" => true],
				["name" => "el token", "type" => "string", "value" => $token, "min" => 6, "max" => 100, "required" => true],
			]);

			$this->response->message->title = "Contraseña actualizada";
			$this->response->message->message = $value->message;

			if($value->status){
				$this->response->message->message = 'Tu correo electrónico no coincide';

				if($password == $password2){

					$this->response->message->title = "Contraseña actualizada";
					$this->response->message->message = "La contraseña no se pudo actualizar por que el correo electrónico no coincide con un token autorizado";
					$data = [];
					$message = $this->load->view('email/updatePassword', $data, true);

					if($this->sendEmail($email, $this->response->message->title, $message)){

						$data = (object)[
							"password" => password_hash($password, PASSWORD_BCRYPT, ["cost" => 11]),
							"token"=> $token,
							"email"=>$email,
							"updated_at"=>date('Y-m-d H:i:s')
						];

						if($this->RegisterLog_model->updatePasswordReset($data)){
							$this->response->message->type = "success";
							$this->response->message->message = "La contraseña se ha actualizada con éxito";
						}
					}

				}
			}
		}

		echo json_encode($this->response);
	}

}
