<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Country_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------

	public function getAll(){
		$this->db->select('countries.id, countries.name, actions.name as action');
		$this->db->from('countries');
		$this->db->join('actions', 'countries.id_actions = actions.id');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id){
		$this->db->select('countries.id, countries.name, actions.name as action');
		$this->db->from('countries');
		$this->db->join('actions', 'countries.id_actions = actions.id');
		$this->db->where('countries.id', $id);
		$query = $this->db->get();
		return ($query) ? $query->result()[0] : false;
	}

	public function insert($data){
		$answer = $this->db->insert('countries', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id){
		$this->db->where('id', $id);
		$answer = $this->db->update('countries', $data);
		return $answer ? true : false;
	}

	public function search($search = '', $start=0, $limit = 10){

		$sql = "SELECT countries.id, countries.name, actions.name as action FROM countries INNER JOIN actions ON countries.id_actions = actions.id WHERE (actions.id != 'ac03') AND (countries.name LIKE '%$search%' AND actions.name LIKE '%$search%') ORDER BY countries.created_at ASC LIMIT $limit OFFSET $start";
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}
	// ------------------------------------------------------------------------

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */
