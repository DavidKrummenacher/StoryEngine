<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Achievements_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all() {
		$query = $this->db->get('story_achievements');
		return $query->result_array();
	}
	
	public function get($id) {
		$query = $this->db->get_where('story_achievements', array('id' => $id));
		return $query->row_array();
	}
	
	public function create($name, $description, $desktop_uri, $mobile_uri, $attribute, $comparison, $value) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'desktop_uri' => $desktop_uri,
			'mobile_uri' => $mobile_uri,
			'attribute' => $attribute,
			'comparison' => $comparison,
			'value' => $value
		);
		
		$this->db->insert('story_achievements', $data);
	}
	
	public function update($id, $name, $description, $desktop_uri, $mobile_uri, $attribute, $comparison, $value) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'desktop_uri' => $desktop_uri,
			'mobile_uri' => $mobile_uri,
			'attribute' => $attribute,
			'comparison' => $comparison,
			'value' => $value
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_achievements', $data);
	}
	
	public function delete($id) {
		$this->db->delete('story_achievements', array('id' => $id));
	}
}