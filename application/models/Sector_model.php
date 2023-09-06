<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sector_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function getAll($idParishes = '')
	{
		$this->db->select('sector.id, sector.name, sector.color, parishes.name as distric, sector.id as codigo, actions.name as action');
		$this->db->from('sector');
		$this->db->join('parishes', 'sector.id_distric = parishes.id');
		$this->db->join('actions', 'sector.id_actions = actions.id');
		if($idParishes != '') $this->db->where('parishes.id', $idParishes);
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getAllSectorDistrict($idDistrict){
		$this->db->select('sector.id, sector.name, sector.color, parishes.name as distric, actions.name as action');
		$this->db->from('sector');
		$this->db->join('parishes', 'sector.id_distric = parishes.id');
		$this->db->join('actions', 'sector.id_actions = actions.id');
		$this->db->where('sector.id_distric', $idDistrict);
		$answer = $this->db->get();

		return ($answer) ? $answer->result() : false;
	}

	public function getForId($idI, $idP = '')
	{
		$this->db->select('sector.id, sector.name, sector.color, parishes.name as distric, sector.id_distric, parishes.id_city, cities.name as city, actions.name as action');
		$this->db->from('sector');
		$this->db->join('parishes', 'sector.id_distric = parishes.id');
		$this->db->join('cities', 'parishes.id_city = cities.id');
		$this->db->join('actions', 'sector.id_actions = actions.id');
		$this->db->where('sector.id', $idI);
		if ($idP != '') $this->db->where('sector.id_distric', $idP);
		$query = $this->db->get();
		if ($query) {
			return $query->result()[0];
		} else {
			return false;
		}
	}

	public function insert($data)
	{
		$answer = $this->db->insert('sector', $data);
		return $answer ? true : false;
	}

	public function updated($data, $id)
	{
		$this->db->where('id', $id);
		$answer = $this->db->update('sector', $data);
		return $answer ? true : false;
	}

	public function search($search = '', $start = 0, $limit = 10, $idPadre = '', $limited=true)
	{
		$sql_complete = ($limited) ? "LIMIT $limit OFFSET $start": "";
		$sql = "SELECT sector.id, sector.name, districs.name as distric, actions.name as action FROM sector
		INNER JOIN parishes districs ON sector.id_distric = districs.id
		INNER JOIN actions ON sector.id_actions = actions.id
		WHERE (districs.id = '$idPadre') AND (sector.name ILIKE '%$search%' OR districs.name ILIKE '%$search%' OR actions.name ILIKE '%$search%')
		ORDER BY sector.created_at DESC $sql_complete";
		$answer = $this->db->query($sql);
		return ($answer) ? $answer->result() : false;
	}

	public function drawCreate(object $data)
	{
		$sql = "INSERT INTO sector_georeferencing VALUES (
			'$data->id',
			ST_GeomFromText('POLYGON(($data->geo))', 4326),
			'$data->id_sector',
			'$data->id_action',
			'$data->created_at',
			'$data->updated_at')";
		$answer = $this->db->query($sql);
		return $answer ? true : false;
	}

	public function drawDelete($id_sector)
	{
		$this->db->where('id_sector', $id_sector);
		$answer = $this->db->delete('sector_georeferencing');
		return $answer ? true : false;
	}

	public function getForMapId($idSector)
	{
		$sql = "SELECT s.name, s.color, ST_AsGeoJSON(locasation)::json AS geom FROM sector_georeferencing geo
		INNER JOIN sector s ON s.id = geo.id_sector WHERE geo.id_sector = '$idSector'";
		$answer = $this->db->query($sql);
		return $answer ? $answer->result() : false;
	}

	public function getAllPolygon($idSector){
		$sql = "SELECT s.id, s.name, geo.id_sector as id_city, ST_AsGeoJSON(locasation)::json AS geom FROM sector_georeferencing geo
		INNER JOIN sector s ON geo.id_sector = s.id
		INNER JOIN parishes p ON s.id_distric = p.id
		WHERE p.id = '$idSector'";
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}

	public function getAllAlarmOfSector($id){
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
		WHERE sec.id = '$id'";
		$answer = $this->db->query($sql);
		return (count($answer->result())>0) ? $answer->result() : false;
	}
	// ------------------------------------------------------------------------

}

/* End of file Sector_model.php */
/* Location: ./application/models/Sector_model.php */
