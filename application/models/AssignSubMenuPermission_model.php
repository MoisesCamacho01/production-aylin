<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AssignSubMenuPermission_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function getAll($id_user_type)
	{
		$this->db->select('assign_submenu_permissions.id, assign_submenu_permissions.id_submenu_permission, assign_submenu_permissions.id_user_type, actions.name as action');
		$this->db->from('assign_submenu_permissions');
		$this->db->join('actions', 'assign_submenu_permissions.id_action = actions.id');
		$this->db->where('assign_submenu_permissions.id_user_type', $id_user_type);
		$this->db->order_by('assign_submenu_permissions.created_at', 'ASC');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function insert($data){
		$answer = $this->db->insert('assign_submenu_permissions', $data);
		return $answer ? true : false;
	}

	public function delete($id_user, $id_submenu){
		$sql="DELETE FROM assign_submenu_permissions WHERE id_user_type = '$id_user' AND id_submenu_permission = '$id_submenu'";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}

  // ------------------------------------------------------------------------

}

/* End of file AssignSubMenuPermission_model.php */
/* Location: ./application/models/AssignSubMenuPermission_model.php */