<?php
defined('BASEPATH') or exit('No direct script access allowed');


class ErrorsController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function error404()
	{
		$this->load->view('errors/pages/404');
	}

}


/* End of file ErrorsController.php */
/* Location: ./application/controllers/ErrorsController.php */
