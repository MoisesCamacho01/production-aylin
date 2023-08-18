<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AssignMenuPermission_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function getAll($id_user_type)
	{
		$this->db->select('assign_menu_permissions.id, assign_menu_permissions.id_menu_permission, assign_menu_permissions.id_user_type, actions.name as action');
		$this->db->from('assign_menu_permissions');
		$this->db->join('actions', 'assign_menu_permissions.id_action = actions.id');
		$this->db->where('assign_menu_permissions.id_user_type', $id_user_type);
		$this->db->order_by('assign_menu_permissions.created_at', 'ASC');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function insert($data){
		$answer = $this->db->insert('assign_menu_permissions', $data);
		return $answer ? true : false;
	}

	public function delete($id_user, $id_menu){
		$sql="DELETE FROM assign_menu_permissions WHERE id_user_type = '$id_user' AND id_menu_permission = '$id_menu'";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}

  // ------------------------------------------------------------------------

}

/* End of file AssignMenuPermission_model.php */
/* Location: ./application/models/AssignMenuPermission_model.php */
