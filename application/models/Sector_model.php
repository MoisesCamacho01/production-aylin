<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sector_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function getAll($idParishes = '')
	{
		$this->db->select('sector.id, sector.name, sector.color, parishes.name as distric, actions.name as action');
		$this->db->from('sector');
		$this->db->join('parishes', 'sector.id_distric = parishes.id');
		$this->db->join('actions', 'sector.id_actions = actions.id');
		if($idParishes != '') $this->db->where('parishes.id', $idParishes);
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getAllSectorDistrict($idDistrict){
		$this->db->select('sector.id, sector.name, sector.color, parishes.name as distric, actions.name as action');
		$this->db->from('sector');
		$this->db->join('parishes', 'sector.id_distric = parishes.id');
		$this->db->join('actions', 'sector.id_actions = actions.id');
		$this->db->where('sector.id_distric', $idDistrict);
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($idI, $idP = '')
	{
		$this->db->select('sector.id, sector.name, sector.color, parishes.name as distric, actions.name as action');
		$this->db->from('sector');
		$this->db->join('parishes', 'sector.id_distric = parishes.id');
		$this->db->join('actions', 'sector.id_actions = actions.id');
		$this->db->where('sector.id', $idI);
		if ($idP != '') $this->db->where('sector.id_distric', $idP);
		$query = $this->db->get();
		if ($query) {
			return $query->result()[0];
		} else {
			return false;
		}
	}

	public function insert($data)
	{
		$answer = $this->db->insert('sector', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('sector', $data);
		return $answer ? true : false;
	}

	public function search($search = '', $start = 0, $limit = 10, $idPadre = '')
	{

		$sql = "SELECT sector.id, sector.name, districs.name as distric, actions.name as action FROM sector
		INNER JOIN parishes districs ON sector.id_distric = districs.id
		INNER JOIN actions ON sector.id_actions = actions.id
		WHERE (districs.id = '$idPadre') AND (sector.name LIKE '%$search%' OR districs.name LIKE '%$search%' OR actions.name LIKE '%$search%')
		ORDER BY sector.created_at DESC LIMIT $limit OFFSET $start";
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function drawCreate(object $data)
	{
		$sql = "INSERT INTO sector_georeferencing(id, locasation, id_sector, id_action, created_at, updated_at) VALUES ('$data->id',ST_SetSRID(ST_MakePoint($data->lng, $data->lat), 4326), '$data->id_sector', '$data->id_action', '$data->created_at', '$data->updated_at')";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}

	public function drawDelete($id_sector)
	{
		$this->db->where('id_sector', $id_sector);
		$answer = $this->db->delete('sector_georeferencing');

		return $answer ? true : false;
	}

	public function getForMapId($idSector)
	{
		$sql = "SELECT sec.color, sec.name, ST_X(ST_AsText(secgeo.locasation)) AS longitud, ST_Y(ST_AsText(secgeo.locasation)) AS latitud FROM sector_georeferencing secgeo RIGHT JOIN sector sec ON secgeo.id_sector = sec.id WHERE sec.id = '$idSector'";
		$answer = $this->db->query($sql);
		return $answer ? $answer->result() : false;
	}
	// ------------------------------------------------------------------------

}

/* End of file Sector_model.php */
/* Location: ./application/models/Sector_model.php */
