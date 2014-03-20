<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_value($key) {
		$query = $this->db->get_where('story_settings', array('key' => $key));
		$result = $query->row_array();
		return $result['value'];
	}
	
	public function get_setting($key) {
		$query = $this->db->get_where('story_settings', array('key' => $key));
		return $query->row_array();
	}
	
	public function set_setting($key, $value) {
		$data = array(
			'key' => $key,
			'value' => $value
		);
		
		$this->db->where('key', $key);
		$this->db->update('story_settings', array('value' => $value));
	}
}