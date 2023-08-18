<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manager_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function getAll()
	{
		$this->db->select('alarm_manager.id, alarm_manager.name, alarm_manager.last_name, alarm_manager.phone, alarm_manager.mobile, actions.name as action');
		$this->db->from('alarm_manager');
		$this->db->join('actions', 'alarm_manager.id_action = actions.id');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id)
	{
		$this->db->select('alarm_manager.id, alarm_manager.name, alarm_manager.last_name, alarm_manager.phone, alarm_manager.mobile, actions.name as action');
		$this->db->from('alarm_manager');
		$this->db->join('actions', 'alarm_manager.id_action = actions.id');
		$this->db->where('alarm_manager.id', $id);
		$query = $this->db->get();
		if ($query) {
			return $query->result()[0];
		} else {
			return false;
		}
	}

	public function insert($data)
	{
		$answer = $this->db->insert('alarm_manager', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('alarm_manager', $data);
		return $answer ? true : false;
	}

	public function search($search = '')
	{
		$this->db->select('alarm_manager.id, alarm_manager.name, alarm_manager.last_name, alarm_manager.phone, alarm_manager.mobile, actions.name as action');
		$this->db->from('alarm_manager');
		$this->db->join('actions', 'alarm_manager.id_action = actions.id');
		$this->db->like('alarm_manager.name', $search);
		$this->db->like('alarm_manager.last_name', $search);
		$this->db->or_like('alarm_manager.phone', $search);
		$this->db->or_like('alarm_manager.mobile', $search);
		$this->db->or_like('actions.name', $search);
		$this->db->order_by('alarm_manager.created_at', 'DESC');
		$answer = $this->db->get();
		return ($answer) ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file AlarmManager_model.php */
/* Location: ./application/models/AlarmManager_model.php */
