<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class TypeNotification_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------

  // ------------------------------------------------------------------------
	public function getAll(){
		$this->db->select('notifications_types.id, notifications_types.name, actions.name as action');
		$this->db->from('notifications_types');
		$this->db->join('actions', 'notifications_types.id_action = actions.id');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id){
		$this->db->select('notifications_types.id, notifications_types.name, actions.name as action');
		$this->db->from('notifications_types');
		$this->db->join('actions', 'notifications_types.id_action = actions.id');
		$this->db->where('notifications_types.id', $id);
		$answer = $this->db->get();
		return ($answer) ? $answer->result()[0] : false;
	}

	public function insert($data){
		$answer = $this->db->insert('notifications_types', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id){
		$this->db->where('id', $id);
		$answer = $this->db->update('notifications_types', $data);
		return $answer ? true : false;
	}

	public function search($search = '', $start=0, $limit=10){
		$sql = "SELECT notifications_types.id, notifications_types.name, actions.name as action FROM notifications_types INNER JOIN actions ON notifications_types.id_action = actions.id WHERE (notifications_types.name LIKE '%$search%' OR actions.name LIKE '%$search%') ORDER BY notifications_types.created_at DESC LIMIT $limit OFFSET $start";

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

  // ------------------------------------------------------------------------

}

/* End of file TypeNotification_model.php */
/* Location: ./application/models/TypeNotification_model.php */
