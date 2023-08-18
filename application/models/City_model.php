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
		$this->db->select('cities.id, cities.name, states.name as state, cities.id_states, actions.name as action');
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

	public function drawCreate(object $data)
	{
		$sql = "INSERT INTO cities_georeferencing(id, locasation, id_city, id_action, created_at, updated_at) VALUES ('$data->id',ST_SetSRID(ST_MakePoint($data->lng, $data->lat), 4326), '$data->id_state', '$data->id_action', '$data->created_at', '$data->updated_at')";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}
	public function drawDelete($id_state)
	{
		$this->db->where('id_city', $id_state);
		$answer = $this->db->delete('cities_georeferencing');

		return $answer ? true : false;
	}
	public function getForMapId($idState)
	{
		$sql = "SELECT sec.name, ST_X(ST_AsText(secgeo.locasation)) AS longitud, ST_Y(ST_AsText(secgeo.locasation)) AS latitud FROM cities_georeferencing secgeo RIGHT JOIN cities sec ON secgeo.id_city = sec.id WHERE sec.id = '$idState'";
		$answer = $this->db->query($sql);
		return $answer ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file City_model.php */
/* Location: ./application/models/City_model.php */
