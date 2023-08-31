<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RegisterLog_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function passwordReset(object $data)
	{
		$userSql = "SELECT * FROM users WHERE email = '$data->email'";
		$user = $this->db->query($userSql);
		if(count($user->result())>0){
			$id_user = $user->result()[0]->id;
			$sqlInsertResetPassword = "INSERT INTO password_resets (id, id_user, token, status,  created_at, updated_at) VALUES('$data->id', '$id_user', '$data->token', 'sin usar', '$data->created_at', '$data->updated_at')";
			$answer = $this->db->query($sqlInsertResetPassword);
			return ($answer) ? true : false;
		}
		return false;
	}

	public function systemAcceso(object $data){
		$userSql = "SELECT * FROM users WHERE email = '$data->email' OR user_name = '$data->email'";
		$user = $this->db->query($userSql);
		if(count($user->result())>0){
			$id_user = $user->result()[0]->id;
			$sqlProfile = "SELECT * FROM profile WHERE id_user = '$id_user'";
			$profile = $this->db->query($sqlProfile);
			if(count($profile->result())<=0) {
				$dataP = [
					"id" => $data->id,
					"name" => '',
					"last_name" => '',
					"id_country" => 'vacio',
					"id_state" => 'vacio',
					"id_city" => 'vacio',
					"id_document_type" => 'X3UDuYQY20230731rW7RhT041358',
					"document_number" => '',
					"address" => '',
					"phone" => '',
					"mobile" => '',
					"photo" => '',
					"id_user" => $id_user,
					"id_action" => 'ac01',
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s')
				];
				$answer = $this->db->insert('profile', $dataP);
			}

			$sqlSystemAccess = "INSERT INTO system_access (id, id_user, token, ip, created_at, updated_at) VALUES('$data->id', '$id_user', '$data->token', '$data->ip', '$data->created_at', '$data->updated_at')";
			$answer = $this->db->query($sqlSystemAccess);
			return ($answer) ? true : false;
		}
		return false;
	}

	public function updatePasswordReset(object $data){
		$sqlToken = "SELECT * FROM password_resets WHERE token = '$data->token' AND  status != 'activado'";
		$token = $this->db->query($sqlToken);

		if(count($token->result())>0){
			$id_user = $token->result()[0]->id_user;
			$sqlUser = "SELECT * FROM users WHERE id = '$id_user'";
			$user = $this->db->query($sqlUser);

			if(count($user->result())>0){
				$emailUser = $user->result()[0]->email;

				if($emailUser == $data->email){
					$sql = "UPDATE users SET password = '$data->password' WHERE email = '$data->email', updated_at = '$data->updated_at'";
					$answer = $this->db->query($sql);

					$id_token = $token->result()[0]->id;
					$sqlToken = "UPDATE password_resets SET status = 'activado' WHERE id = '$id_token', updated_at = '$data->updated_at'";
					$answerToken = $this->db->query($sqlToken);

					return ($answer AND $answerToken) ? true : false;
				}
			}
		}

		return false;
	}

	public function RegisterHistoryUseSystem(object $data){
		$sql = "INSERT INTO history VALUES('$data->id', '$data->observation', '$data->id_user', '$data->created_at', '$data->updated_at')";
		$answer = $this->db->query($sql);
		return ($answer) ? true : false;
	}

	public function getSuccessAccess($search = '', $start=0, $limit=10, $report=false){
		$sql = "SELECT sa.ip, u.email, pr.name, pr.last_name, sa.created_at FROM system_access sa INNER JOIN users u ON sa.id_user = u.id INNER JOIN profile pr ON u.id = pr.id_user WHERE (u.email LIKE '%$search%' OR sa.ip LIKE '%$search%' OR pr.last_name LIKE '%$search%') ORDER BY sa.created_at DESC LIMIT $limit OFFSET $start";
		if($report){
			$sql = "SELECT sa.ip, u.email, pr.name, pr.last_name, sa.created_at FROM system_access sa INNER JOIN users u ON sa.id_user = u.id INNER JOIN profile pr ON u.id = pr.id_user";
		}
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function getPasswordReset($search = '', $start=0, $limit=10, $report=false){

		$sql = "SELECT pr.status, u.email, p.name, p.last_name, pr.created_at FROM password_resets pr INNER JOIN users u ON pr.id_user = u.id INNER JOIN profile p ON u.id = p.id_user WHERE (pr.status LIKE '%$search%' OR u.email LIKE '%$search%' OR p.name LIKE '%$search%' OR p.last_name LIKE '%$search%') ORDER BY pr.created_at DESC LIMIT $limit OFFSET $start";
		if($report){
			$sql = "SELECT pr.status, u.email, p.name, p.last_name, pr.created_at FROM password_resets pr INNER JOIN users u ON pr.id_user = u.id INNER JOIN profile p ON u.id = p.id_user";
		}
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}
	public function getActiveAlarm($search = '', $start=0, $limit=10, $report=false){
		$sql = "SELECT nl.why_activate as why, nl.ip, s.name as sector, u.email, u.user_name, p.name, p.last_name, nl.created_at FROM notification_logs nl INNER JOIN sector s ON nl.id_sector = s.id INNER JOIN users u ON nl.id_user = u.id INNER JOIN profile p ON u.id = p.id_user WHERE (nl.why_activate LIKE '%$search%' OR nl.ip LIKE '%$search%' OR s.name LIKE '%$search%' OR u.email LIKE '%$search%' OR u.user_name LIKE '%$search%' OR p.name LIKE '%$search%' OR p.last_name LIKE '%$search%') ORDER BY nl.created_at DESC LIMIT $limit OFFSET $start";
		
		if($report){
			$sql = "SELECT nl.why_activate as why, nl.ip, s.name as sector, u.email, u.user_name, p.name, p.last_name, nl.created_at FROM notification_logs nl INNER JOIN sector s ON nl.id_sector = s.id INNER JOIN users u ON nl.id_user = u.id INNER JOIN profile p ON u.id = p.id_user";
		}

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function getHistory($search = '', $start=0, $limit=10, $report=false){
		$sql = "SELECT h.observation, u.email, u.user_name, h.created_at FROM history h INNER JOIN users u ON h.id_user = u.id WHERE (h.observation LIKE '%$search%' OR u.email LIKE '%$search%') ORDER BY h.created_at DESC LIMIT $limit OFFSET $start";
		if($report){
			$sql = "SELECT h.observation, u.email, u.user_name, h.created_at FROM history h INNER JOIN users u ON h.id_user = u.id";
		}
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function getAll($table){
		$sql = "SELECT * FROM $table";
		$answer = $this->db->query($sql);

		return ($answer) ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file RegisterLog_model.php */
/* Location: ./application/models/RegisterLog_model.php */
