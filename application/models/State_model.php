<?php
defined('BASEPATH') or exit('No direct script access allowed');

class State_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function getAll($idCountry = '')
	{
		if($idCountry !=''){
			$where = "states.id != 'vacio' AND states.id_countries = '$idCountry'";
		}else{
			$where = "states.id != 'vacio'";
		}

		$sql = 'states.id, states.name, countries.name as country, actions.name as action';
		if($idCountry != '') $sql = 'states.id, states.name, countries.name as country, states.id_countries, actions.name as action';
		$this->db->select($sql);
		$this->db->from('states');
		$this->db->join('countries', 'states.id_countries = countries.id');
		$this->db->join('actions', 'states.id_actions = actions.id');
		$this->db->where($where);
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id)
	{
		$this->db->select('states.id, states.name, states.id_countries, actions.name as action');
		$this->db->from('states');
		$this->db->join('countries', 'states.id_countries = countries.id');
		$this->db->join('actions', 'states.id_actions = actions.id');
		$this->db->where('states.id', $id);
		$query = $this->db->get();
		if ($query) {
			return $query->result()[0];
		} else {
			return false;
		}
	}

	public function insert($data)
	{
		$answer = $this->db->insert('states', $data);
		return $answer ? true : false;
	}
	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('states', $data);
		return $answer ? true : false;
	}
	public function search($search = '', $start=0, $limit=10)
	{
		$sql = "SELECT s.id, s.name, c.name AS country, s.id_countries, a.name AS ACTION
		FROM states s
		INNER JOIN countries c ON s.id_countries = c.id
		INNER JOIN actions a ON s.id_actions = a.id
		WHERE (s.id != 'vacio' and c.id = 'C001') AND (s.name LIKE '%%' OR c.name LIKE '%%' OR a.name LIKE '%%')
		ORDER BY s.created_at ASC LIMIT 10 OFFSET 0";
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}
	public function drawCreate(object $data)
	{
		$sql = "INSERT INTO states_georeferencing VALUES (
			'$data->id',
			ST_GeomFromText('POLYGON(($data->geo))', 4326),
			'$data->id_city',
			'$data->id_action',
			'$data->created_at',
			'$data->updated_at')";
		$answer = $this->db->query($sql);

		return ($answer) ? true : false;
	}

	public function drawDelete($idState)
	{
		$this->db->where('id_state', $idState);
		$answer = $this->db->delete('states_georeferencing');

		return $answer ? true : false;
	}
	public function getForMapId($idState)
	{
		$sql = "SELECT s.name, ST_AsGeoJSON(locasation)::json AS geom FROM states_georeferencing geo
		INNER JOIN states s ON s.id = geo.id_state WHERE geo.id_state = '$idState'";
		$answer = $this->db->query($sql);
		return $answer ? $answer->result() : false;
	}

	public function getAllPolygon($idCountry){
		$sql = "SELECT s.name, geo.id_state as id_city, ST_AsGeoJSON(locasation)::json AS geom FROM states_georeferencing geo
		INNER JOIN states s ON geo.id_state = s.id
		INNER JOIN countries c ON s.id_countries = c.id
		WHERE c.id = '$idCountry'";
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}

	public function getAllAlarmOfState($idState){
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
		WHERE s.id = '$idState'";
		echo $sql;
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file State_model.php */
/* Location: ./application/models/State_model.php */
