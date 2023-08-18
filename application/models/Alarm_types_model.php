<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alarm_types_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function getAll()
	{
		$this->db->select('alarm_types.id, alarm_types.name, actions.name as action');
		$this->db->from('alarm_types');
		$this->db->join('actions', 'alarm_types.id_action = actions.id');
		$this->db->where('actions !=', 'ac03');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id)
	{
		$this->db->select('alarm_types.id, alarm_types.name');
		$this->db->from('alarm_types');
		$this->db->join('actions', 'alarm_types.id_action = actions.id');
		$this->db->where('alarm_types.id', $id);
		$query = $this->db->get();
		if ($query) {
			return $query->result()[0];
		} else {
			return false;
		}
	}

	public function insert($data)
	{
		$answer = $this->db->insert('alarm_types', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('alarm_types', $data);
		return $answer ? true : false;
	}

	public function search($search='',$start=0, $limit=10)
	{
		$this->db->select('alarm_types.id, alarm_types.name, actions.name as action');
		$this->db->from('alarm_types');
		$this->db->join('actions', 'alarm_types.id_action = actions.id');
		$this->db->like('alarm_types.name', $search);
		$this->db->or_like('actions.name', $search);
		$this->db->order_by('alarm_types.created_at', 'ASC');
		$this->db->limit($limit);
		$this->db->offset($start);
		$answer = $this->db->get();
		return ($answer) ? $answer->result() : false;
	}

  // ------------------------------------------------------------------------

}

/* End of file Alarm_types_model.php */
/* Location: ./application/models/Alarm_types_model.php */
