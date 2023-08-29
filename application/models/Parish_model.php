<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Parish_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------

  public function getAll($id_city = '')
	{
		$this->db->select('parishes.id, parishes.name, cities.name as city, actions.name as action');
		$this->db->from('parishes');
		$this->db->join('cities', 'parishes.id_city = cities.id');
		$this->db->join('actions', 'parishes.id_actions = actions.id');
		if($id_city != '') $this->db->where('parishes.id_city', $id_city);
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($idI, $idP='')
	{
		$this->db->select('parishes.id, parishes.name, cities.name as city, actions.name as action');
		$this->db->from('parishes');
		$this->db->join('cities', 'parishes.id_city = cities.id');
		$this->db->join('actions', 'parishes.id_actions = actions.id');
		$this->db->where('parishes.id', $idI);
		if($idP != '') $this->db->where('parishes.id_city', $idP);
		$query = $this->db->get();
		if ($query) {
			return $query->result()[0];
		} else {
			return false;
		}
	}

	public function insert($data)
	{
		$answer = $this->db->insert('parishes', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('parishes', $data);
		return $answer ? true : false;
	}

	public function search($search = '', $start=0, $limit=10, $idPadre = '')
	{
		$sql = "SELECT parishes.id, parishes.name, cities.name as city, actions.name as action FROM parishes
		INNER JOIN cities ON parishes.id_city = cities.id
		INNER JOIN actions ON parishes.id_actions = actions.id
		WHERE (cities.id = '$idPadre') AND (parishes.name LIKE '%$search%' OR cities.name LIKE '%$search%' OR actions.name LIKE '%$search%')
		ORDER BY parishes.created_at DESC LIMIT $limit OFFSET $start";
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function drawCreate(object $data)
	{
		$sql = "INSERT INTO parishes_georeferencing VALUES (
			'$data->id',
			ST_GeomFromText('POLYGON(($data->geo))', 4326),
			'$data->id_parish',
			'$data->id_action',
			'$data->created_at',
			'$data->updated_at')";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}
	public function drawDelete($id_state)
	{
		$this->db->where('id_parish', $id_state);
		$answer = $this->db->delete('parishes_georeferencing');

		return $answer ? true : false;
	}
	public function getForMapId($idParish)
	{
		$sql = "SELECT p.name, ST_AsGeoJSON(locasation)::json AS geom FROM parishes_georeferencing geo
		INNER JOIN parishes p ON p.id = geo.id_parish
		WHERE geo.id_parish = '$idParish'";
		$answer = $this->db->query($sql);
		return $answer ? $answer->result() : false;
	}

	public function getAllPolygon($idCity){
		$sql = "SELECT p.id as id_city, p.name,
		geo.id_parish as id_city, ST_AsGeoJSON(locasation)::json AS geom FROM parishes_georeferencing geo
		INNER JOIN parishes p ON geo.id_parish = p.id
		INNER JOIN cities c ON p.id_city = c.id
		WHERE c.id = '$idCity'";

		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}

	public function getAllAlarmOfParish($id){
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
		ST_AsGeoJSON(locasation)::json AS geom FROM alarm_georeferencing geo
		INNER JOIN alarms a ON geo.id_alarm = a.id
		INNER JOIN alarm_manager am ON a.id_alarm_manager = am.id
		INNER JOIN sector sec ON a.id_sector = sec.id
		INNER JOIN parishes p ON sec.id_distric = p.id
		INNER JOIN cities c ON p.id_city = c.id
		INNER JOIN states s ON c.id_states = s.id
		WHERE p.id = '$id'";
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}

  // ------------------------------------------------------------------------

}

/* End of file Parish_model.php */
/* Location: ./application/models/Parish_model.php */
