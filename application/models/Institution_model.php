<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Institution_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------

public function getAll(){
	$this->db->select('institutions.id, institutions.name, institutions.phone, institutions.mobile, countries.name as country, actions.name as action');
	$this->db->from('institutions');
	$this->db->join('countries', 'institutions.id_country = countries.id');
	$this->db->join('actions', 'institutions.id_action = actions.id');
	$answer = $this->db->get();

	return ($answer) ? $answer->result() : false;
}

public function getForId($id){
	$this->db->select('institutions.id, institutions.name, institutions.phone, institutions.mobile, countries.id as country');
	$this->db->from('institutions');
	$this->db->join('countries', 'institutions.id_country = countries.id');
	$this->db->join('actions', 'institutions.id_action = actions.id');
	$this->db->where('institutions.id', $id);
	$query = $this->db->get();
	if ($query) {
		return $query->result()[0];
	} else {
		return false;
	}
}

public function insert($data){
	$answer = $this->db->insert('institutions', $data);
	return $answer ? true : false;
}

public function updated($data, $id){
	$this->db->where('id', $id);
	$answer = $this->db->update('institutions', $data);
	return $answer ? true : false;
}

public function search($search = ''){
	$this->db->select('institutions.id, institutions.name, institutions.phone, institutions.mobile, countries.name as country, actions.name as action');
	$this->db->from('institutions');
	$this->db->join('countries', 'institutions.id_country = countries.id');
	$this->db->join('actions', 'institutions.id_action = actions.id');
	$this->db->like('institutions.name', $search);
	$this->db->or_like('institutions.phone', $search);
	$this->db->or_like('institutions.mobile', $search);
	$this->db->or_like('countries.name', $search);
	$this->db->or_like('actions.name', $search);
	$this->db->order_by('institutions.created_at', 'ASC');
	$answer = $this->db->get();
	return ($answer) ? $answer->result() : false;
}

  // ------------------------------------------------------------------------

}

/* End of file Institution_model.php */
/* Location: ./application/models/Institution_model.php */
