<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'PermissionsUserController.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MY_Controller extends CI_Controller
{
	protected $data = array();
	protected $table = "";
	protected $id;
	public $response;

	public $submenu;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('TryCatch_model');
		$this->load->model('MenuPermission_model');
		$this->load->model('SubMenuPermission_model');
		$this->load->model('ButtonPermission_model');
		$this->response = (object)[
			"data" => "",
			"message" => (object)[
				"type" => "error",
				"title" => "Usuario Creado",
				"message" => "El usuario no pudo ser creado con éxito"
			]
		];
	}

	public function layout()
	{
		$user = $this->session->userdata('usuario');

		if ($user->id) {
			$permissionsUser = new PermissionsUserController(
				$user,
				$this->MenuPermission_model,
				$this->SubMenuPermission_model,
				$this->ButtonPermission_model
			);
			$this->data['sidebar'] = $permissionsUser->getSidebar();
			$this->data['buttonTop'] = $permissionsUser->buttonSuperior($this->submenu);
			$permissionsUser->buttonMenu($this->submenu);

			$this->template['header'] = $this->load->view('layout/admin/header', $this->data, TRUE);
			$this->template['sidbar'] = $this->load->view('layout/admin/sidbar', $this->data, TRUE);
			$this->template['nav'] = $this->load->view('layout/admin/nav', $this->data, TRUE);
			$this->template['page'] = $this->load->view($this->page, $this->data, TRUE);
			$this->template['footer'] = $this->load->view('layout/admin/footer', $this->data, TRUE);
			$this->load->view('layout/admin/plantilla', $this->template);
		} else {
			redirect('/');
		}
	}

	public function code($length)
	{
		$charset = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codigo = "";

		for ($i = 0; $i < $length; $i++) {
			$rand = rand(0, strlen($charset) - 1);
			$codigo .= substr($charset, $rand, 1);
		}

		return $codigo;
	}

	public function generateId()
	{
		return $this->code(8) . date('Ymd') . $this->code(6) . date('His');
	}

	public function excelGenerate($header, $body, $name)
	{
		$excel = new Spreadsheet();
		$sheet = $excel->getActiveSheet();

		$columnIndex = 'A';
		$rowIndex = 1;

		// Configurar las dimensiones de la columna y establecer el contenido de la primera fila
		foreach ($header as $column) {
			$sheet->getColumnDimension($columnIndex)->setAutoSize(true);
			$sheet->setCellValue($columnIndex . $rowIndex, $column);
			$columnIndex++;
		}

		$i = 2;

		foreach ($body as $row) {
			$status = '';
			if(isset($row->action)){
				if ($row->action == 'create') $status = 'Activo';
				if ($row->action == 'suspend') $status = 'Suspendido';
				if ($row->action == 'edit') $status = 'Actualizado';
				if ($row->action == 'delete') $status = 'Eliminado';
			}

			$row_vars = get_object_vars($row);
			unset($row_vars['id']); // ELIMINAR LA id
			unset($row_vars['action']); // ELIMINAR LA action
			$columnIndex = 'A';
			foreach ($row_vars as $value) {
				$sheet->setCellValue("$columnIndex$i", $value);
				$columnIndex++;
			}
			$sheet->setCellValue("$columnIndex$i", $status);
			$i++;
		}

		$writer = new Xls($excel);
		$fileName = $name . '.xls';

		// DOWNLOAD EXCEL

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $fileName . '"');

		$writer->save('php://output');
	}

	// DUPLICATE SQL
	public function setTable($table)
	{
		$this->table = $table;
	}
	public function setId($id)
	{
		$this->id = $id;
	}
	public function duplicate($attributes = [])
	{
		$array = json_decode(json_encode($attributes), true);
		$response = (object)[
			"message" => "correcto",
			"status" => true
		];

		foreach ($array as $attribute) {
			if ($this->TryCatch_model->duplicate($this->table, $attribute['attribute'], $attribute['value'])) {
				$response->message = $attribute['message'] . " ya esta registrado";
				$response->status = false;
			}
		}

		return $response;
	}
	public function duplicateUpdate($attributes = [])
	{
		$array = json_decode(json_encode($attributes), true);
		$response = (object)[
			"message" => "correcto",
			"status" => true
		];

		foreach ($array as $attribute) {
			if ($this->TryCatch_model->duplicateUpdate($this->table, $attribute['attribute'], $attribute['value'], $this->id)) {
				$response->message = $attribute['message'] . " ya esta registrado";
				$response->status = false;
			}
		}

		return $response;
	}
	public function existRegister($foreignKey, $value)
	{
		$response = (object)[
			"message" => "No existen valores",
			"status" => false
		];

		$answer = $this->TryCatch_model->existRegister($this->table, $foreignKey, $value);
		if ($answer) {
			$response->message = "No puedes eliminar estos registros por que tiene un registro relacionado";
			$response->status = true;
		}

		return $response;
	}

	public function buttonMenu($submenu)
	{
		$user = $this->session->userdata('usuario');
		$permissionsUser = new PermissionsUserController(
			$user,
			$this->MenuPermission_model,
			$this->SubMenuPermission_model,
			$this->ButtonPermission_model
		);
		return $permissionsUser->buttonMenu($submenu);
	}

	public function sendEmail($to, $subject, $message){
		//Create an instance; passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->SMTPDebug = 0;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'mail.wfss-ec.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'prueba@wfss-ec.com';                     //SMTP username
			$mail->Password   = '1EPFRg-Q)oQ.';                               //SMTP password
			$mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
			$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` //no borrar

			// codifications
			$mail->CharSet = 'UTF-8';

			//Recipients
			$mail->setFrom('prueba@wfss-ec.com', 'AYLIN');
			$mail->addAddress($to);     //Add a recipient
			// $mail->addReplyTo('info@example.com', 'Information');
			// $mail->addCC('cc@example.com');
			// $mail->addBCC('bcc@example.com');

			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $message;

			// echo 'Message has been sent';
			return ($mail->send()) ? true : false;
		} catch (Exception $e) {
			// echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			return false;
		}
	}

}


/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
