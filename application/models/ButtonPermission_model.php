<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ButtonPermission_model extends CI_Model {

  // ------------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------
	public function getAll($type = "")
	{
		$this->db->select('buttons_permissions.id, buttons_permissions.name, buttons_permissions.icon, actions.name as action');
		$this->db->from('buttons_permissions');
		$this->db->join('types_buttons', 'buttons_permissions.id_types_button = types_buttons.id');
		$this->db->join('actions', 'buttons_permissions.id_action = actions.id');
		if($type != '') $this->db->where('buttons_permissions.id_types_button', $type);
		$this->db->order_by('buttons_permissions.created_at', 'ASC');
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getButtonAssign($id_submenu, $id_user, $type)
	{
		$sql = "select button.id, button.name, button.icon, assign_button.id_submenu_permission as id_submenu from assign_button_permissions assign_button INNER JOIN buttons_permissions button ON assign_button.id_button_permission = button.id where assign_button.id_user_type = '$id_user' AND assign_button.id_submenu_permission = '$id_submenu' AND button.id_types_button = '$type' ORDER BY button.created_at ASC";
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function getForId($id)
	{
		$this->db->select('buttons_permissions.id, buttons_permissions.name, buttons_permissions.icon, actions.name as action');
		$this->db->from('buttons_permissions');
		$this->db->join('types_buttons', 'buttons_permissions.id_types_button = types_buttons.id');
		$this->db->join('actions', 'buttons_permissions.id_action = actions.id');
		$this->db->where('buttons_permissions.id', $id);
		$answer = $this->db->get();
		return ($answer) ? $answer->result()[0] : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('buttons_permissions', $data);
		return $answer ? true : false;
	}

  // ------------------------------------------------------------------------
  public function index()
  {
    //
  }

  // ------------------------------------------------------------------------

}

/* End of file ButtonPermission_model.php */
/* Location: ./application/models/ButtonPermission_model.php */
