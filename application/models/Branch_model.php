<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function getAll()
	{
		$this->db->select('branches.id, branches.name, branches.address, branches.phone, branches.mobile, institutions.name as institution, countries.name as country, states.name as state, cities.name as city, actions.name as action');
		$this->db->from('branches');
		$this->db->join('institutions', 'branches.id_institution = institutions.id');
		$this->db->join('countries', 'branches.id_country = countries.id');
		$this->db->join('states', 'branches.id_states = states.id');
		$this->db->join('cities', 'branches.id_cities = cities.id');
		$this->db->join('actions', 'branches.id_action = actions.id');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($idI, $idB)
	{
		$this->db->select('branches.id, branches.name, branches.address, branches.phone, branches.mobile, institutions.id as institution, countries.id as country, states.id as state, cities.id as city, actions.name as action');
		$this->db->from('branches');
		$this->db->join('institutions', 'branches.id_institution = institutions.id');
		$this->db->join('countries', 'branches.id_country = countries.id');
		$this->db->join('states', 'branches.id_states = states.id');
		$this->db->join('cities', 'branches.id_cities = cities.id');
		$this->db->join('actions', 'branches.id_action = actions.id');
		$this->db->where('branches.id', $idB);
		$this->db->where('branches.id_institution', $idI);
		$query = $this->db->get();
		if ($query) {
			return $query->result()[0];
		} else {
			return false;
		}
	}

	public function insert($data)
	{
		$answer = $this->db->insert('branches', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('branches', $data);
		return $answer ? true : false;
	}

	public function search($search = '', $idPadre = '')
	{
		$this->db->select('branches.id, branches.name, branches.address, branches.phone, branches.mobile, institutions.name as institution, countries.name as country, states.name as state, cities.name as city, actions.name as action');
		$this->db->from('branches');
		$this->db->join('institutions', 'branches.id_institution = institutions.id');
		$this->db->join('countries', 'branches.id_country = countries.id');
		$this->db->join('states', 'branches.id_states = states.id');
		$this->db->join('cities', 'branches.id_cities = cities.id');
		$this->db->join('actions', 'branches.id_action = actions.id');
		$this->db->like('branches.name', $search);
		$this->db->or_like('branches.address', $search);
		$this->db->or_like('branches.phone', $search);
		$this->db->or_like('branches.mobile', $search);
		$this->db->or_like('institutions.name', $search);
		$this->db->or_like('countries.name', $search);
		$this->db->or_like('states.name', $search);
		$this->db->or_like('cities.name', $search);
		$this->db->or_like('actions.name', $search);
		if($idPadre != '') $this->db->where('branches.id_institution', $idPadre);
		$this->db->order_by('branches.created_at', 'ASC');
		$answer = $this->db->get();
		return ($answer) ? $answer->result() : false;
	}

  // ------------------------------------------------------------------------

}

/* End of file Branch_model.php */
/* Location: ./application/models/Branch_model.php */
