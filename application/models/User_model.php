<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function startSession($user, $password){
		$sql = "select users.id, users.user_name, users.email, users.id_user_type, users.id_branch, users.password from users INNER JOIN actions ON users.id_action = actions.id WHERE (user_name = '$user' OR email ='$user') AND (actions.id != 'ac04' AND actions.id != 'ac03')";
		$answer = $this->db->query($sql);
		if(count($answer->result())>0){
			$result = $answer->result();
			return password_verify($password, $result[0]->password) ? $answer->result()[0] : false;
		}
		return false;
	}

	public function getAll($type="web"){
		$condition = "";
		if($type == "web"){
			$condition = "AND (users.id_user_type != 'T002')";
		}else if($type == "movil"){
			$condition = "AND (users.id_user_type = 'T002')";
		}

		$sql = "SELECT users.id, users.user_name, users.email, user_types.name AS user_type, actions.name AS action FROM users INNER JOIN user_types ON users.id_user_type = user_types.id INNER JOIN actions ON users.id_action = actions.id WHERE (users.id != 'U001') $condition";

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function getAllAdmin(){
		$sql = "SELECT COUNT(*) FROM users WHERE users.id_user_type != 'T002'";
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result()[0]->count : false;
	}

	public function getAllMovil(){
		$sql = "SELECT count(*) FROM users WHERE users.id_user_type = 'T002'";
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result()[0]->count : false;
	}

	public function getForId($id){
		$this->db->select('users.id, users.user_name, users.email, users.id_user_type as user_type, actions.name as action');
		$this->db->from('users');
		$this->db->join('user_types', 'users.id_user_type = user_types.id');
		$this->db->join('actions', 'users.id_action = actions.id');
		$this->db->where('users.id', $id);
		$answer = $this->db->get();
		return ($answer) ? $answer->result()[0] : false;

	}

	public function insert($data){
		$answer = $this->db->insert('users', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id){
		$this->db->where('id', $id);
		$answer = $this->db->update('users', $data);
		return $answer ? true : false;
	}

	public function search($search = '', $start=0, $limit=10, $type='web', $limited=true){
		$sql = "SELECT * FROM users WHERE id = '0'";
		$sql_complete = ($limited) ? "LIMIT $limit OFFSET $start" : "";
		if($type == 'web'){
			$sql = "SELECT users.id, users.user_name, users.email, user_types.name as user_type, actions.name AS action FROM users INNER JOIN user_types ON users.id_user_type = user_types.id INNER JOIN actions ON users.id_action = actions.id WHERE (users.id != 'U001' AND users.id_user_type != 'T002' ) AND (users.user_name LIKE '%$search%' OR users.email LIKE '%$search%' OR user_types.name LIKE '%$search%' OR actions.name LIKE '%$search%') ORDER BY users.created_at DESC $sql_complete";
		}else{
			$sql = "SELECT users.id, users.user_name, users.email, user_types.name as user_type, actions.name AS action FROM users INNER JOIN user_types ON users.id_user_type = user_types.id INNER JOIN actions ON users.id_action = actions.id WHERE (users.id != 'U001' AND users.id_user_type = 'T002' ) AND (users.user_name LIKE '%$search%' OR users.email LIKE '%$search%' OR user_types.name LIKE '%$search%' OR actions.name LIKE '%$search%') ORDER BY users.created_at DESC $sql_complete";
		}

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}
	// ------------------------------------------------------------------------

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */
