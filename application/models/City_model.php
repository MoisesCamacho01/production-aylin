<?php
defined('BASEPATH') or exit('No direct script access allowed');

class City_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function getAll($id_states = '')
	{
		$this->db->select('cities.id, cities.name, states.name as state, actions.name as action');
		$this->db->from('cities');
		$this->db->join('states', 'cities.id_states = states.id');
		$this->db->join('actions', 'cities.id_actions = actions.id');
		if($id_states != '') $this->db->where('states.id', $id_states);
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id)
	{
		$this->db->select('cities.id, cities.name, cities.id_states as state, countries.id as country');
		$this->db->from('cities');
		$this->db->join('states', 'cities.id_states = states.id');
		$this->db->join('actions', 'cities.id_actions = actions.id');
		$this->db->join('countries', 'states.id_countries = countries.id');
		$this->db->where('cities.id', $id);
		$query = $this->db->get();
		if ($query) {
			return $query->result()[0];
		} else {
			return false;
		}
	}

	public function insert($data)
	{
		$answer = $this->db->insert('cities', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('cities', $data);
		return $answer ? true : false;
	}

	public function search($search='',$start=0, $limit=10)
	{
		$this->db->select('cities.id, cities.name, states.name as states, cities.id_states, actions.name as action');
		$this->db->from('cities');
		$this->db->join('states', 'cities.id_states = states.id');
		$this->db->join('actions', 'cities.id_actions = actions.id');
		$this->db->like('cities.name', $search);
		$this->db->or_like('states.name', $search);
		$this->db->or_like('actions.name', $search);
		$this->db->order_by('cities.created_at', 'ASC');
		$this->db->limit($limit);
		$this->db->offset($start);
		$answer = $this->db->get();
		return ($answer) ? $answer->result() : false;
	}

	public function drawCreate(object $data){
		$sql = "INSERT INTO cities_georeferencing VALUES (
			'$data->id',
			ST_GeomFromText('POLYGON(($data->geo))', 4326),
			'$data->id_city',
			'$data->id_action',
			'$data->created_at',
			'$data->updated_at')";
		$answer = $this->db->query($sql);

		return ($answer) ? true : false;
	}

	public function drawDelete($id_state)
	{
		$this->db->where('id_city', $id_state);
		$answer = $this->db->delete('cities_georeferencing');

		return $answer ? true : false;
	}
	public function getForMapId($idCity)
	{
		$sql = "SELECT c.name, ST_AsGeoJSON(locasation)::json AS geom FROM cities_georeferencing geo
		INNER JOIN cities c ON geo.id_city = c.id
		WHERE geo.id_city = '$idCity'";
		// echo $sql;
		$answer = $this->db->query($sql);
		return $answer ? $answer->result() : false;
	}

	public function getAllPolygon($idState){
		$sql = "SELECT c.name, geo.id_city, ST_AsGeoJSON(locasation)::json AS geom FROM cities_georeferencing geo
		INNER JOIN cities c ON geo.id_city = c.id
		INNER JOIN states s ON c.id_states = s.id
		WHERE s.id = '$idState'";
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}

	public function getAllAlarmOfCity($idCity){
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
		WHERE c.id = '$idCity'";
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file City_model.php */
/* Location: ./application/models/City_model.php */
