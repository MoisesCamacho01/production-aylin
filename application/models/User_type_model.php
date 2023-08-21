<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Type_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function getAll(){
		$this->db->select('user_types.id, user_types.name, actions.name as action');
		$this->db->from('user_types');
		$this->db->join('actions', 'user_types.id_action = actions.id');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id){
		$this->db->select('user_types.id, user_types.name, actions.name as action');
		$this->db->from('user_types');
		$this->db->join('actions', 'user_types.id_action = actions.id');
		$this->db->where('user_types.id', $id);
		$answer = $this->db->get();
		return ($answer) ? $answer->result()[0] : false;
	}

	public function insert($data){
		$answer = $this->db->insert('user_types', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id){
		$this->db->where('id', $id);
		$answer = $this->db->update('user_types', $data);
		return $answer ? true : false;
	}

	public function search($search = '', $start=0, $limit=10){
		$sql = "SELECT user_types.id, user_types.name, actions.name as action FROM user_types INNER JOIN actions ON user_types.id_action = actions.id WHERE (user_types.name LIKE '%$search%' OR actions.name LIKE '%$search%') ORDER BY user_types.created_at DESC LIMIT $limit OFFSET $start";

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file User_type_model.php */
/* Location: ./application/models/User_type_model.php */
