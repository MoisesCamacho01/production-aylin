<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SubMenuPermission_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------

	// ------------------------------------------------------------------------
	public function getAll($idMenu="")
	{
		$this->db->select('submenu_permissions.id, submenu_permissions.name, submenu_permissions.url, submenu_permissions.id_menu, actions.name as action');
		$this->db->from('submenu_permissions');
		$this->db->join('actions', 'submenu_permissions.id_action = actions.id');
		if($idMenu != "") $this->db->where('submenu_permissions.id_menu', $idMenu);
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getMenuAssign($id_menu, $id_user)
	{
		$sql = "select submenu.id, submenu.name, submenu.icon, submenu.url  from assign_submenu_permissions assign_submenu INNER JOIN submenu_permissions submenu ON assign_submenu.id_submenu_permission = submenu.id where assign_submenu.id_user_type = '$id_user' AND submenu.id_menu = '$id_menu' ORDER BY submenu.created_at ASC";
		
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id)
	{
		$this->db->select('subMenu_permissions.id, subMenu_permissions.name, actions.name as action');
		$this->db->from('subMenu_permissions');
		$this->db->join('actions', 'subMenu_permissions.id_action = actions.id');
		$this->db->where('subMenu_permissions.id', $id);
		$answer = $this->db->get();
		return ($answer) ? $answer->result()[0] : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('subMenu_permissions', $data);
		return $answer ? true : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file SubMenuPermission_model.php */
/* Location: ./application/models/SubMenuPermission_model.php */
