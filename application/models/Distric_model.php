<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distric_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function getAll($id='')
	{
		$this->db->select('districs.id, districs.name, parishes.name as parish, actions.name as action');
		$this->db->from('districs');
		$this->db->join('parishes', 'districs.id_parish = parishes.id');
		$this->db->join('actions', 'districs.id_actions = actions.id');
		if($id != '') $this->db->where('districs.id_parish', $id);
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($idI, $idP='')
	{
		$this->db->select('districs.id, districs.name, parishes.name as parish, actions.name as action');
		$this->db->from('districs');
		$this->db->join('parishes', 'districs.id_parish = parishes.id');
		$this->db->join('actions', 'districs.id_actions = actions.id');
		$this->db->where('districs.id', $idI);
		if($idP != '') $this->db->where('districs.id_parish', $idP);
		$query = $this->db->get();
		if ($query) {
			return $query->result()[0];
		} else {
			return false;
		}
	}

	public function insert($data)
	{
		$answer = $this->db->insert('districs', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('districs', $data);
		return $answer ? true : false;
	}

	public function search($search = '', $start=0, $limit=10, $idPadre = '')
	{
		$sql = "SELECT districs.id, districs.name, parishes.name as parish, actions.name as action FROM districs
		INNER JOIN parishes ON districs.id_parish = parishes.id
		INNER JOIN actions ON districs.id_actions = actions.id
		WHERE (parishes.id = '$idPadre') AND (districs.name LIKE '%$search%' OR parishes.name LIKE '%$search%' OR actions.name LIKE '%$search%')
		ORDER BY districs.created_at DESC LIMIT $limit OFFSET $start";

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}


  // ------------------------------------------------------------------------

}

/* End of file Distric_model.php */
/* Location: ./application/models/Distric_model.php */
