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
		$sql = 'states.id, states.name, countries.name as country, actions.name as action';
		if($idCountry != '') $sql = 'states.id, states.name, countries.name as country, states.id_countries, actions.name as action';
		$this->db->select($sql);
		$this->db->from('states');
		$this->db->join('countries', 'states.id_countries = countries.id');
		$this->db->join('actions', 'states.id_actions = actions.id');
		if($idCountry != '') $this->db->where('states.id_countries', $idCountry);
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
		$this->db->select('states.id, states.name, countries.name as country, states.id_countries, actions.name as action');
		$this->db->from('states');
		$this->db->join('countries', 'states.id_countries = countries.id');
		$this->db->join('actions', 'states.id_actions = actions.id');
		$this->db->like('states.name', $search);
		$this->db->or_like('countries.name', $search);
		$this->db->or_like('actions.name', $search);
		$this->db->order_by('states.created_at', 'ASC');
		$this->db->limit($limit);
		$this->db->offset($start);
		$answer = $this->db->get();
		return ($answer) ? $answer->result() : false;
	}
	public function drawCreate(object $data)
	{
		$sql = "INSERT INTO states_georeferencing(id, locasation, id_state, id_action, created_at, updated_at) VALUES ('$data->id',ST_SetSRID(ST_MakePoint($data->lng, $data->lat), 4326), '$data->id_state', '$data->id_action', '$data->created_at', '$data->updated_at')";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}
	public function drawDelete($id_state)
	{
		$this->db->where('id_state', $id_state);
		$answer = $this->db->delete('states_georeferencing');

		return $answer ? true : false;
	}
	public function getForMapId($idState)
	{
		$sql = "SELECT sec.name, ST_X(ST_AsText(secgeo.locasation)) AS longitud, ST_Y(ST_AsText(secgeo.locasation)) AS latitud FROM states_georeferencing secgeo RIGHT JOIN states sec ON secgeo.id_state = sec.id WHERE sec.id = '$idState'";
		$answer = $this->db->query($sql);
		return $answer ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file State_model.php */
/* Location: ./application/models/State_model.php */
