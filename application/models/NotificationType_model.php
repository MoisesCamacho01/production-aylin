<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class NotificationType_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function getAll(){
	$this->db->select('id, name');
	$answer = $this->db->get('notifications_types');

	return ($answer) ? $answer->result() : false;
  }

  // ------------------------------------------------------------------------

}

/* End of file NotificationType_model.php */
/* Location: ./application/models/NotificationType_model.php */
