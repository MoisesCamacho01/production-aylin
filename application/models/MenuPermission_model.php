<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MenuPermission_model extends CI_Model
{

	// ------------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------
	public function getAll()
	{
		$this->db->select('menu_permissions.id, menu_permissions.name, menu_permissions.icon, actions.name as action');
		$this->db->from('menu_permissions');
		$this->db->join('actions', 'menu_permissions.id_action = actions.id');
		$this->db->where('menu_permissions.id !=', 'MP004');
		$this->db->where('menu_permissions.id !=', 'MP005');
		$this->db->where('menu_permissions.id !=', 'MP007');
		$this->db->where('menu_permissions.id !=', 'MP008');
		$this->db->where('menu_permissions.id !=', 'MP009');
		$this->db->where('menu_permissions.id !=', 'MP0011');
		$this->db->where('menu_permissions.id !=', 'MP0012');
		$this->db->order_by('menu_permissions.created_at', 'ASC');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}
	public function getMenuAssign($id_user)
	{
		$sql = "select menu.id, menu.name, menu.icon from assign_menu_permissions assign_menu INNER JOIN menu_permissions menu ON assign_menu.id_menu_permission = menu.id where (assign_menu.id_user_type = '$id_user') AND (menu.id != 'MP004' AND menu.id != 'MP005' AND menu.id != 'MP007' AND menu.id != 'MP0010' AND menu.id != 'MP0012') ORDER BY menu.created_at ASC";
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id)
	{
		$this->db->select('menu_permissions.id, menu_permissions.name, actions.name as action');
		$this->db->from('menu_permissions');
		$this->db->join('actions', 'menu_permissions.id_action = actions.id');
		$this->db->where('menu_permissions.id', $id);
		$answer = $this->db->get();
		return ($answer) ? $answer->result()[0] : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('menu_permissions', $data);
		return $answer ? true : false;
	}



	// ------------------------------------------------------------------------

}

/* End of file MenuPermission_model.php */
/* Location: ./application/models/MenuPermission_model.php */
