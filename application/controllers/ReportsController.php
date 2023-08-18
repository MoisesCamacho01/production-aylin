<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require 'ValidateController.php';

class ReportsController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sector_model');
		$this->load->model('State_model');
		$this->load->model('Manager_model');
		$this->load->model('NotificationType_model');
		$this->load->model('RegisterLog_model');
	}

	public function index($submenu)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/reports2.js?t=5',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'REPORTES',
			'states' => $this->State_model->getAll('C001'),
			'managers' => $this->Manager_model->getAll(),
			'buttonNotifications' => $this->NotificationType_model->getAll(),
			'js' => $js,
		];

		$this->page = 'app/admin/reports/maps';
		$this->layout();
	}

	public function successAccess($submenu)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/logs.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Acceso Correcto',
			'js' => $js,
			'url' => site_url('reports-sa/search'),
			'quantity' => count($this->RegisterLog_model->getAll('system_access'))
		];

		$this->page = 'app/admin/reports/successAccess';
		$this->layout();
	}

	public function passwordReset($submenu)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/logs.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Acceso Correcto',
			'js' => $js,
			'url' => site_url('reports-pr/search'),
			'quantity' => count($this->RegisterLog_model->getAll('password_resets'))
		];

		$this->page = 'app/admin/reports/passwordReset';
		$this->layout();
	}

	public function activeAlarm($submenu)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/logs.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Acceso Correcto',
			'js' => $js,
			'url' => site_url('reports-aa/search'),
			'quantity' => count($this->RegisterLog_model->getAll('notification_logs'))
		];

		$this->page = 'app/admin/reports/activeAlarm';
		$this->layout();
	}

	public function historyUseSystem($submenu)
	{
		$js = [
			'resources/librerias/paginator/paginator.js',
			'resources/src/js/logs.js',
		];

		$this->session->set_userdata('submenu', $submenu);
		$this->submenu = $submenu;

		$this->data = [
			'title' => 'Acceso Correcto',
			'js' => $js,
			'url' => site_url('reports-hus/search'),
			'quantity' => count($this->RegisterLog_model->getAll('history'))
		];

		$this->page = 'app/admin/reports/history';
		$this->layout();
	}

	public function searchAccessCorrect()
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->RegisterLog_model->getSuccessAccess($search, $start, $limit);
		$table = htmlspecialchars_decode($this->tableAccessCorrect($getSearch));
		$this->response->data = $table;
		$this->response->message->type = 'success';
		$this->response->message->title = "Registro Encontrado";
		$this->response->message->message = "Registros encontrados con éxito";

		echo json_encode($this->response);
	}

	public function searchPasswordReset()
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->RegisterLog_model->getPasswordReset($search, $start, $limit);
		$table = htmlspecialchars_decode($this->tablePasswordReset($getSearch));
		$this->response->data = $table;
		$this->response->message->type = 'success';
		$this->response->message->title = "Registro Encontrado";
		$this->response->message->message = "Registros encontrados con éxito";

		echo json_encode($this->response);
	}

	public function searchActiveAlarm()
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->RegisterLog_model->getActiveAlarm($search, $start, $limit);
		$table = htmlspecialchars_decode($this->tableActiveAlarm($getSearch));
		$this->response->data = $table;
		$this->response->message->type = 'success';
		$this->response->message->title = "Registro Encontrado";
		$this->response->message->message = "Registros encontrados con éxito";

		echo json_encode($this->response);
	}

	public function searchHistory()
	{
		$search = htmlspecialchars($this->input->post('search'));
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$getSearch = $this->RegisterLog_model->getHistory($search, $start, $limit);
		$table = htmlspecialchars_decode($this->tableHistory($getSearch));
		$this->response->data = $table;
		$this->response->message->type = 'success';
		$this->response->message->title = "Registro Encontrado";
		$this->response->message->message = "Registros encontrados con éxito";

		echo json_encode($this->response);
	}

	public function tableAccessCorrect($getRegisters)
	{
		$template = '<tr><td><p>No se encontraron datos</p></td></tr>';
		if ($getRegisters) {
			$i = 0;
			$template = '';
			foreach ($getRegisters as $row) {
				$i++;
				$template .= "<tr>
					<td>{$i}</td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->ip}</strong></td>
					<td>{$row->email}</td>
					<td>{$row->name} {$row->last_name}</td>
					<td>{$row->created_at}</td>
					</tr>";
			}
		}
		return $template;
	}

	public function tablePasswordReset($getRegisters)
	{
		$template = '<tr><td><p>No se encontraron datos</p></td></tr>';
		if ($getRegisters) {
			$i = 0;
			$template = '';
			foreach ($getRegisters as $row) {
				$i++;
				$template .= "<tr>
					<td>{$i}</td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->email}</strong></td>
					<td>{$row->name} {$row->last_name}</td>
					<td>{$row->status}</td>
					<td>{$row->created_at}</td>
					</tr>";
			}
		}
		return $template;
	}

	public function tableActiveAlarm($getRegisters)
	{
		$template = '<tr><td><p>No se encontraron datos</p></td></tr>';
		if ($getRegisters) {
			$i = 0;
			$template = '';
			foreach ($getRegisters as $row) {
				$i++;
				$template .= "<tr>
					<td>{$i}</td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->ip}</strong></td>
					<td>{$row->email}</td>
					<td>{$row->name} {$row->last_name}</td>
					<td>{$row->sector}</td>
					<td>{$row->why}</td>
					<td>{$row->created_at}</td>
					</tr>";
			}
		}
		return $template;
	}

	public function tableHistory($getRegisters)
	{
		$template = '<tr><td><p>No se encontraron datos</p></td></tr>';
		if ($getRegisters) {
			$i = 0;
			$template = '';
			foreach ($getRegisters as $row) {
				$i++;
				$template .= "<tr>
					<td>{$i}</td>
					<td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>{$row->email}</strong></td>
					<td>{$row->user_name}</td>
					<td>{$row->observation}</td>
					<td>{$row->created_at}</td>
					</tr>";
			}
		}
		return $template;
	}

	public function pdfAccessCorrect()
	{
		$thead = ['N°', 'IP', 'EMAIL', 'NOMBRE', 'APELLIDO','FECHA DE ACCESO'];
		$tbody = $this->RegisterLog_model->getSuccessAccess('', 0, 0, true);

		$data = [
			'title' => 'accessCorrect',
			'titleDocument' => 'Acceso correcto',
			'thead' => $thead,
			'tbody' => $tbody
		];

		$mPdf = new \Mpdf\Mpdf();
		$document = $this->load->view('pdf/table.php', $data, true);
		$mPdf->WriteHTML($document);
		$mPdf->Output();
	}

	public function pdfPasswordReset()
	{
		$thead = ['N°', 'ESTADO', 'EMAIL', 'NOMBRE', 'APELLIDO', 'FECHA DE ACCESO'];
		$tbody = $this->RegisterLog_model->getPasswordReset('',0,0,true);

		$data = [
			'title' => 'Cambio de contraseña',
			'titleDocument' => 'Registro de actualización de contraseñas',
			'thead' => $thead,
			'tbody' => $tbody
		];

		$mPdf = new \Mpdf\Mpdf();
		$document = $this->load->view('pdf/table.php', $data, true);
		$mPdf->WriteHTML($document);
		$mPdf->Output();
	}

	public function pdfActiveAlarm()
	{
		$thead = ['N°', '¿POR QUÉ?', 'IP', 'SECTOR', 'EMAIL','USERNAME', 'NOMBRE', 'APELLIDO', 'FECHA DE ACTIVACIÓN'];
		$tbody = $this->RegisterLog_model->getActiveAlarm('',0,0,true);

		$data = [
			'title' => 'Activación de alarmas',
			'titleDocument' => 'Historial de activación de alarmas',
			'thead' => $thead,
			'tbody' => $tbody
		];

		$mPdf = new \Mpdf\Mpdf();
		$document = $this->load->view('pdf/table.php', $data, true);
		$mPdf->WriteHTML($document);
		$mPdf->Output();
	}

	public function pdfHistory()
	{
		$thead = ['N°', 'USUARIO', 'EMAIL', 'TIPO DE USUARIO', 'ESTADO'];
		$tbody = $this->RegisterLog_model->getHistory('',0,0,true);
		$data = [
			'title' => 'Historial',
			'titleDocument' => 'Historial de seguimiento',
			'thead' => $thead,
			'tbody' => $tbody
		];

		$mPdf = new \Mpdf\Mpdf();
		$document = $this->load->view('pdf/table.php', $data, true);
		$mPdf->WriteHTML($document);
		$mPdf->Output();
	}

	public function excelAccessCorrect()
	{
		$header = ['IP', 'EMAIL', 'NOMBRE', 'APELLIDO', 'FECHA DE ACCESO'];
		$users = $this->RegisterLog_model->getSuccessAccess('',0,0,true);
		$this->excelGenerate($header, $users, 'Access-correct');
	}

	public function excelPasswordReset()
	{
		$header = ['ESTADO', 'EMAIL', 'NOMBRE', 'APELLIDO', 'FECHA DE ACCESO'];
		$users = $this->RegisterLog_model->getPasswordReset('',0,0,true);
		$this->excelGenerate($header, $users, 'password-reset');
	}

	public function excelActiveAlarm()
	{
		$header = ['¿POR QUÉ?', 'IP', 'SECTOR', 'EMAIL','USERNAME', 'NOMBRE', 'APELLIDO', 'FECHA DE ACTIVACIÓN'];
		$users = $this->RegisterLog_model->getActiveAlarm('',0,0,true);
		$this->excelGenerate($header, $users, 'active-alarm');
	}

	public function excelHistory()
	{
		$header = ['USUARIO', 'EMAIL', 'TIPO DE USUARIO', 'ESTADO'];
		$users = $this->RegisterLog_model->getHistory('',0,0,true);
		$this->excelGenerate($header, $users, 'history');
	}
}


/* End of file ReportsController.php */
/* Location: ./application/controllers/ReportsController.php */
