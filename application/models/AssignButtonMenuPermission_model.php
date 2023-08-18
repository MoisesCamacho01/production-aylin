<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AssignButtonMenuPermission_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function getAll($id_user_type)
	{
		$this->db->select('assign_button_permissions.id, assign_button_permissions.id_submenu_permission, assign_button_permissions.id_button_permission, assign_button_permissions.id_user_type, actions.name as action');
		$this->db->from('assign_button_permissions');
		$this->db->join('actions', 'assign_button_permissions.id_action = actions.id');
		$this->db->where('assign_button_permissions.id_user_type', $id_user_type);
		$this->db->order_by('assign_button_permissions.created_at', 'ASC');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function insert($data){
		$answer = $this->db->insert('assign_button_permissions', $data);
		return $answer ? true : false;
	}

	public function delete($id_user, $id_button, $id_submenu){
		$sql="DELETE FROM assign_button_permissions WHERE id_user_type = '$id_user' AND id_submenu_permission = '$id_submenu' AND id_button_permission = '$id_button'";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}

  // ------------------------------------------------------------------------

}

/* End of file AssignButtonMenuPermission_model.php */
/* Location: ./application/models/AssignButtonMenuPermission_model.php */
