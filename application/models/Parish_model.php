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
		$sql = "INSERT INTO parishes_georeferencing(id, locasation, id_parish, id_action, created_at, updated_at) VALUES ('$data->id',ST_SetSRID(ST_MakePoint($data->lng, $data->lat), 4326), '$data->id_state', '$data->id_action', '$data->created_at', '$data->updated_at')";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}
	public function drawDelete($id_state)
	{
		$this->db->where('id_parish', $id_state);
		$answer = $this->db->delete('parishes_georeferencing');

		return $answer ? true : false;
	}
	public function getForMapId($idState)
	{
		$sql = "SELECT sec.name, ST_X(ST_AsText(secgeo.locasation)) AS longitud, ST_Y(ST_AsText(secgeo.locasation)) AS latitud FROM parishes_georeferencing secgeo RIGHT JOIN parishes sec ON secgeo.id_parish = sec.id WHERE sec.id = '$idState'";
		$answer = $this->db->query($sql);
		return $answer ? $answer->result() : false;
	}

  // ------------------------------------------------------------------------

}

/* End of file Parish_model.php */
/* Location: ./application/models/Parish_model.php */
