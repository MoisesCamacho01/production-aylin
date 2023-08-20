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
	public function getAll()
	{
		$sql = "select alarms.id, alarms.code, concat(manager.name, ' ', manager.last_name) as name_manager, sector.name as sector, actions.name as action from alarms inner join alarm_manager manager on alarms.id_alarm_manager = manager.id inner join sector on alarms.id_sector = sector.id INNER JOIN actions on alarms.id_action = actions.id";
		$answer = $this->db->query($sql);

		return ($answer) ? $answer->result() : false;
	}

	public function getAllofSector($idP){
		$sql = "SELECT alarms.id, alarms.code, alarms.id_sector, sector.name As sector,
		ST_X(ST_AsText(localization)) AS longitud, ST_Y(ST_AsText(localization)) AS latitud,
		alarms.id_alarm_manager, alarms.id_user, actions.name As action
		FROM alarms INNER JOIN sector ON alarms.id_sector = sector.id
		INNER JOIN alarm_manager ON alarms.id_alarm_manager = alarm_manager.id
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

	public function search($search = '', $idPadre = '')
	{

		$sql = "select alarms.id, alarms.code, concat(manager.name, ' ', manager.last_name) as name_manager, sector.name as sector, actions.name as action from alarms inner join alarm_manager manager on alarms.id_alarm_manager = manager.id inner join sector on alarms.id_sector = sector.id INNER JOIN actions on alarms.id_action = actions.id where (sector.id = '{$idPadre}') and (alarms.code like '%{$search}%' or manager.name like '%{$search}%' or manager.last_name like '%{$search}%' or sector.name like '%{$idPadre}%' or actions.name like '%{$search}%')";

		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function drawCreate(object $data)
	{
		$sql = "INSERT INTO alarm_georeferencing(id, localization, id_alarm, id_action, created_at, updated_at) VALUES ('$data->id',ST_SetSRID(ST_MakePoint($data->lng, $data->lat), 4326), '$data->id_alarm', '$data->id_action', '$data->created_at', '$data->updated_at')";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}

	public function drawDelete($id_alarms)
	{
		$this->db->where('id_alarm', $id_alarms);
		$answer = $this->db->delete('alarm_georeferencing');

		return $answer ? true : false;
	}

	public function getForMapId($idSector)
	{
		$sql = "SELECT alarms.code, ST_X(ST_AsText(algeo.localization)) AS longitud, ST_Y(ST_AsText(algeo.localization)) AS latitud FROM alarm_georeferencing algeo INNER JOIN alarms ON alarms.id = algeo.id_alarm WHERE id_alarm = '$idSector'";
		$answer = $this->db->query($sql);
		return $answer ? $answer->result() : false;
	}

	// ------------------------------------------------------------------------

}

/* End of file Alarm_model.php */
/* Location: ./application/models/Alarm_model.php */
