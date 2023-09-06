<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alarm_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function getAll($idSector = '')
	{
		if($idSector != ''){
			$sql = "SELECT alarms.id, alarms.code, ST_X(ST_AsText(alarms.localization)) AS longitud, ST_Y(ST_AsText(alarms.localization)) AS latitud, concat(manager.name, ' ', manager.last_name) AS name_manager, sector.name AS sector, actions.name AS action from alarms INNER JOIN alarm_manager manager on alarms.id_alarm_manager = manager.id INNER JOIN sector on alarms.id_sector = sector.id INNER JOIN actions on alarms.id_action = actions.id WHERE sector.id = '$idSector'";
		}else{
			$sql = "SELECT alarms.id, alarms.code, ST_X(ST_AsText(alarms.localization)) AS longitud, ST_Y(ST_AsText(alarms.localization)) AS latitud, concat(manager.name, ' ', manager.last_name) as name_manager, sector.name as sector, actions.name as action from alarms INNER JOIN alarm_manager manager on alarms.id_alarm_manager = manager.id INNER JOIN sector on alarms.id_sector = sector.id INNER JOIN actions on alarms.id_action = actions.id";
		}
		$answer = $this->db->query($sql);

		return ($answer) ? $answer->result() : false;
	}

	public function getAllofSector($idP){

		$sql = "SELECT alarms.id, alarms.code, alarms.id_sector, sector.name As sector, sector.id_actions as a_sector, parishes.id_actions as a_parish, cities.id_actions as a_city, alarms.id_action as a_alarm,
		ST_X(ST_AsText(localization)) AS longitud, ST_Y(ST_AsText(localization)) AS latitud,
		alarms.id_alarm_manager, alarms.id_user, actions.name As action
		FROM alarms
		INNER JOIN alarm_manager ON alarms.id_alarm_manager = alarm_manager.id
        INNER JOIN sector ON alarms.id_sector = sector.id
        INNER JOIN parishes ON sector.id_distric = parishes.id
        INNER JOIN cities ON parishes.id_city = cities.id
		INNER JOIN actions ON alarms.id_action = actions.id
		WHERE alarms.id_sector = '$idP'";

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function getForId($idI, $idP = '')
	{
		$sql = "SELECT alarms.id, alarms.code, sector.name As sector,
		ST_X(ST_AsText(localization)) AS longitud, ST_Y(ST_AsText(localization)) AS latitud,
		alarms.id_alarm_manager, alarms.id_user, actions.name As action
		FROM alarms INNER JOIN sector ON alarms.id_sector = sector.id
		INNER JOIN alarm_manager ON alarms.id_alarm_manager = alarm_manager.id
		INNER JOIN actions ON alarms.id_action = actions.id
		WHERE alarms.id = '$idI' AND alarms.id_sector = '$idP'";

		$query = $this->db->query($sql);
		return ($query) ? $query->result()[0] : false;
	}

	public function insert(object $data)
	{
		$sql = "INSERT INTO alarms(id, code, id_sector, localization, id_alarm_manager, id_user, id_action, created_at, updated_at) VALUES ('$data->id', '$data->code', '$data->id_sector', ST_SetSRID(ST_MakePoint($data->longitude, $data->latitude), 4326), '$data->id_alarm_manager', '$data->id_user', '$data->id_action', '$data->created_at', '$data->updated_at')";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}

	public function updated(object $data, $id)
	{
		$sql = "UPDATE alarms SET code='$data->code', id_sector='$data->id_sector', localization=ST_SetSRID(ST_MakePoint($data->longitude, $data->latitude), 4326), id_alarm_manager='$data->id_alarm_manager', id_user='$data->id_user', id_action='$data->id_action', updated_at='$data->updated_at' WHERE id = '$id'";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}

	public function search($search = '', $start=0, $limit=10, $idPadre = '', $limited=true)
	{
		$sql_complete = ($limited) ? "LIMIT $limit OFFSET $start": "";

		$sql = "SELECT alarms.id, alarms.code, concat(manager.name, ' ', manager.last_name) as name_manager, sector.name as sector, actions.name as action from alarms INNER JOIN alarm_manager manager on alarms.id_alarm_manager = manager.id INNER JOIN sector on alarms.id_sector = sector.id INNER JOIN actions on alarms.id_action = actions.id where (sector.id = '{$idPadre}') and (alarms.code ILIKE '%{$search}%' or manager.name ILIKE '%{$search}%' or manager.last_name ILIKE '%{$search}%' or sector.name ILIKE '%{$idPadre}%' or actions.name ILIKE '%{$search}%') ORDER BY alarms.created_at DESC $sql_complete";

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function drawCreate(object $data)
	{
		$sql = "INSERT INTO alarm_georeferencing VALUES (
			'$data->id',
			ST_GeomFromText('POLYGON(($data->geo))', 4326),
			'$data->id_alarm',
			'$data->id_action',
			'$data->created_at',
			'$data->updated_at')";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}

	public function drawDelete($id_alarms)
	{
		$this->db->where('id_alarm', $id_alarms);
		$answer = $this->db->delete('alarm_georeferencing');

		return $answer ? true : false;
	}

	public function getForMapId($idAlarm)
	{
		$sql = "SELECT a.code, ST_X(ST_AsText(a.localization)) AS lng_alarm, ST_Y(ST_AsText(a.localization)) AS lat_alarm,
		ST_AsGeoJSON(locasation)::json AS geom FROM alarm_georeferencing geo
		INNER JOIN alarms a ON a.id = geo.id_alarm
		WHERE geo.id_alarm = '$idAlarm'";
		$answer = $this->db->query($sql);

		if(count($answer->result())<=0){
			$sql = "SELECT a.code, ST_X(ST_AsText(a.localization)) AS lng_alarm, ST_Y(ST_AsText(a.localization)) AS lat_alarm
			FROM alarms a WHERE a.id = '$idAlarm'";
			$answer = $this->db->query($sql);
		}

		return $answer ? $answer->result() : false;
	}

	public function getAllPolygon($idSector){
		$sql = "SELECT a.code as name, geo.id_alarm as id_city, ST_AsGeoJSON(locasation)::json AS geom FROM alarm_georeferencing geo
		INNER JOIN alarms a ON geo.id_alarm = a.id
		INNER JOIN sector s ON a.id_sector = s.id
		WHERE s.id = '$idSector'";
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}

	public function searchAlarm($code){
		$sql = "SELECT a.id, a.code, sec.id_actions as a_sector, a.id_sector, sec.name As sector,
		p.name as parish,
		c.name as canton,
		CONCAT(am.name,' ',am.last_name) as name_manager,
		am.phone,
		am.mobile,
		a.id_user,
		p.id_actions as a_parish,
		c.id_actions as a_city,
		a.id_action as a_alarm,
		ST_X(ST_AsText(a.localization)) AS lng_alarm,
		ST_Y(ST_AsText(a.localization)) AS lat_alarm,
		geo.id_alarm as id_city,
		ST_AsGeoJSON(locasation)::json AS geom,
		(SELECT nt.id FROM notification_logs nl
		INNER JOIN notifications_types nt ON nl.id_notification_type = nt.id
		WHERE nl.id_sector = sec.id ORDER BY nl.created_at DESC LIMIT 1) as estado_alarma
		FROM alarm_georeferencing geo
		INNER JOIN alarms a ON geo.id_alarm = a.id
		INNER JOIN alarm_manager am ON a.id_alarm_manager = am.id
		INNER JOIN sector sec ON a.id_sector = sec.id
		INNER JOIN parishes p ON sec.id_distric = p.id
		INNER JOIN cities c ON p.id_city = c.id
		INNER JOIN states s ON c.id_states = s.id
		WHERE a.code = '$code'";
		// echo $sql;
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file Alarm_model.php */
/* Location: ./application/models/Alarm_model.php */
