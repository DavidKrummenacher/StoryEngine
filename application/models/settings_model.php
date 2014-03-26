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
	
	
	public function get_story_setting($key) {
		$query = $this->db->get_where('story_settings', array('key' => $key));
		return $query->row_array();
	}
	
	public function get_story_settings($key = null) {
			if($key != null)
			{
				$query = $this->db->get_where('story_settings',array('key' => $key));
				$row = $query->row(); 
				if($row) {
					return $row->value;
				} else {
					return false;
				}
			} else {
				$query = $this->db->get('story_settings');
				return $query->result_array();
			}
			
		}
	
	public function set_story_setting($key, $value) {
		// TODO: Make this work...
		$data = array(
			'key' => $key,
			'value' => $value
		);
		
		$this->db->where('key', $key);
		$this->db->update('story_settings', array('value' => $value));
	}
	
	
}