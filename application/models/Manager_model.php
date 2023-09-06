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

	public function searchAlarm($code){
		$sql = "SELECT a.id, a.code, sec.id_actions as a_sector, a.id_sector, sec.name As sector,
		p.name as parish,
		c.name as canton,
		CONCAT(am.name,' ',am.last_name) as name_manager,
		am.phone,
		am.mobile,
		a.id_user,
		p.id_actions as a_parish,
		c.id_actions as a_city,
		a.id_action as a_alarm,
		ST_X(ST_AsText(a.localization)) AS lng_alarm,
		ST_Y(ST_AsText(a.localization)) AS lat_alarm,
		geo.id_alarm as id_city,
		ST_AsGeoJSON(locasation)::json AS geom,
		(SELECT nt.id FROM notification_logs nl
		INNER JOIN notifications_types nt ON nl.id_notification_type = nt.id
		WHERE nl.id_sector = sec.id ORDER BY nl.created_at DESC LIMIT 1) as estado_alarma
		FROM alarm_georeferencing geo
		INNER JOIN alarms a ON geo.id_alarm = a.id
		INNER JOIN alarm_manager am ON a.id_alarm_manager = am.id
		INNER JOIN sector sec ON a.id_sector = sec.id
		INNER JOIN parishes p ON sec.id_distric = p.id
		INNER JOIN cities c ON p.id_city = c.id
		INNER JOIN states s ON c.id_states = s.id
		WHERE CONCAT(am.name,' ', am.last_name) ILIKE '%$code%'";
		// echo $sql;
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file AlarmManager_model.php */
/* Location: ./application/models/AlarmManager_model.php */
