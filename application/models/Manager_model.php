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

	public function search($search = '', $start=0, $limit=10, $limited=true){

		$sql_complete = ($limited) ? "LIMIT $limit OFFSET $start" : "";

		$sql = "SELECT am.id, am.name, am.last_name, am.phone, am.mobile, a.name as action
		FROM alarm_manager am INNER JOIN actions a ON am.id_action = a.id
		WHERE am.name ILIKE '%$search%' OR am.last_name ILIKE '%$search%'
		OR am.phone ILIKE '%$search%' OR am.mobile ILIKE '%$search%'
		OR a.name ILIKE '%$search%' ORDER BY am.created_at DESC $sql_complete";
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file AlarmManager_model.php */
/* Location: ./application/models/AlarmManager_model.php */
