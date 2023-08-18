<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DocumentType_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function getAll()
	{
		$this->db->select('document_type.id, document_type.name, actions.name as action');
		$this->db->from('document_type');
		$this->db->join('actions', 'document_type.id_action = actions.id');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id)
	{
		$this->db->select('document_type.id, document_type.name, actions.name as action');
		$this->db->from('document_type');
		$this->db->join('actions', 'document_type.id_action = actions.id');
		$this->db->where('document_type.id', $id);
		$answer = $this->db->get();
		return ($answer) ? $answer->result()[0] : false;
	}

	public function insert($data)
	{
		$answer = $this->db->insert('document_type', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('document_type', $data);
		return $answer ? true : false;
	}

	public function search($search = '', $start = 0, $limit = 10)
	{
		$sql = "SELECT document_type.id, document_type.name, actions.name as action FROM document_type INNER JOIN actions ON document_type.id_action = actions.id WHERE (document_type.name LIKE '%$search%' OR actions.name LIKE '%$search%') ORDER BY document_type.created_at DESC LIMIT $limit OFFSET $start";

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file DocumentType_model.php */
/* Location: ./application/models/DocumentType_model.php */
