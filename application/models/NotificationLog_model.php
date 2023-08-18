<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationLog_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function insert(object $data)
	{
		$sql = "INSERT INTO notification_logs(id, why_activate, localization, ip, id_user, id_sector, id_notification_type, id_action, created_at, updated_at) VALUES ('$data->id', '$data->why_activate' ,ST_SetSRID(ST_MakePoint($data->lng, $data->lat), 4326), '$data->ip', '$data->id_user', '$data->id_sector', '$data->id_notification_type', '$data->id_action', '$data->created_at', '$data->updated_at')";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}

  // ------------------------------------------------------------------------

}

/* End of file NotificationLog_model.php */
/* Location: ./application/models/NotificationLog_model.php */
