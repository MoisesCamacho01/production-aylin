<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function historyNotifications()
	{
		$sql = "SELECT s.name as sector, p.name, p.last_name, nl.created_at, nt.name as type FROM notification_logs nl
	 INNER JOIN sector s ON nl.id_sector = s.id INNER JOIN users u ON nl.id_user = u.id INNER JOIN profile p ON u.id = p.id_user INNER JOIN notifications_types nt ON nl.id_notification_type = nt.id";

		$answer = $this->db->query($sql);

		return ($answer) ? $answer->result() : false;
	}

	public function getAlarmActive()
	{
		$sql = "SELECT alarms.id, alarms.code, concat(manager.name, ' ', manager.last_name) as name_manager, sector.name as sector, actions.name as action from alarms INNER JOIN alarm_manager manager on alarms.id_alarm_manager = manager.id INNER JOIN sector on alarms.id_sector = sector.id INNER JOIN actions on alarms.id_action = actions.id WHERE actions.id = 'ac01' OR actions.id = 'ac02'";
		$answer = $this->db->query($sql);

		return ($answer) ? $answer->result() : false;
	}

	public function getAlarmSuspend()
	{
		$sql = "SELECT alarms.id, alarms.code, concat(manager.name, ' ', manager.last_name) as name_manager, sector.name as sector, actions.name as action from alarms INNER JOIN alarm_manager manager on alarms.id_alarm_manager = manager.id INNER JOIN sector on alarms.id_sector = sector.id INNER JOIN actions on alarms.id_action = actions.id WHERE actions.id = 'ac04'";
		$answer = $this->db->query($sql);

		return ($answer) ? $answer->result() : false;
	}

	public function getTotalMotiveAlarm(){
		$sql = "SELECT TO_CHAR(nl.created_at, 'YYYY-MM') AS mes,
					COUNT(*) AS cantidad_registros,
					nt.name
			FROM
					notification_logs nl
			JOIN
					notifications_types nt ON nl.id_notification_type = nt.id
			WHERE
					EXTRACT(YEAR FROM nl.created_at) = 2023
			GROUP BY
					mes, nt.name
			ORDER BY
					mes;
			";

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;

	}

	public function getSeguimientoActivacionAlarma($tipo){
		$quien = ($tipo == 'todos') ? "" : "AND nt.name = '$tipo'";
 		$sql = "SELECT
		-- TO_CHAR(nl.created_at, 'DD') || ' DE ' ||
		-- CASE
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 1 THEN 'ENERO'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 2 THEN 'FEBRERO'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 3 THEN 'MARZO'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 4 THEN 'ABRIL'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 5 THEN 'MAYO'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 6 THEN 'JUNIO'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 7 THEN 'JULIO'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 8 THEN 'AGOSTO'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 9 THEN 'SEPTIEMBRE'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 10 THEN 'OCTUBRE'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 11 THEN 'NOVIEMBRE'
		-- 	 WHEN EXTRACT(MONTH FROM nl.created_at) = 12 THEN 'DICIEMBRE'
		-- 			END || ' DEL ' ||
					TO_CHAR(nl.created_at, 'YYYY-MM-DD') AS fecha,
					COUNT(*) AS cantidad_registros,
					nt.name
			FROM
					notification_logs nl
			JOIN
					notifications_types nt ON nl.id_notification_type = nt.id
			WHERE
					EXTRACT(YEAR FROM nl.created_at) = 2023 $quien
			GROUP BY
					fecha, nt.name
			ORDER BY fecha";

		$answer = $this->db->query($sql);

		return ($answer) ? $answer->result() : false;
	}
	// ------------------------------------------------------------------------

}

/* End of file Dashboard_model.php */
/* Location: ./application/models/Dashboard_model.php */
