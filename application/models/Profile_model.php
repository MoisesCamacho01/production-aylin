<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function getProfilePorIdUser($id)
	{
		$sql = "SELECT * FROM profile WHERE id_user = '$id'";
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result()[0] : false;
	}

	public function insert($data){
		$answer = $this->db->insert('profile', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id){
		$this->db->where('id_user', $id);
		$answer = $this->db->update('profile', $data);
		return $answer ? true : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file Profile_model.php */
/* Location: ./application/models/Profile_model.php */
