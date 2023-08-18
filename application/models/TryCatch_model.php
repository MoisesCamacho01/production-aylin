<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TryCatch_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------

  // ------------------------------------------------------------------------
  public function duplicate($table, $attribute, $value){
	$this->db->where("$attribute", "$value");
	$answer = $this->db->get($table);
	return (count($answer->result())>0) ? true : false;
  }

  public function duplicateUpdate($table, $attribute, $value, $id){
	$this->db->where("$attribute", "$value");
	$this->db->where("id !=", $id);
	$answer = $this->db->get($table);
	return (count($answer->result())>0) ? true : false;
  }

  public function existRegister($table, $foreignKey, $value){
	$this->db->where("$foreignKey", "$value");
	$answer = $this->db->get($table);
	return (count($answer->result())>0) ? true : false;
  }


  // ------------------------------------------------------------------------

}

/* End of file TryCatch_model.php */
/* Location: ./application/models/TryCatch_model.php */
