<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_page_images() {
		$query = $this->db->get('story_page_images');
		return $query->result_array();
	}
	
	public function get_page_image($id) {
		$query = $this->db->get_where('story_page_images', array('id' => $id));
		return $query->row_array();
	}
	
	public function create_page_image($name, $description, $desktop_uri, $mobile_uri) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'desktop_uri' => $desktop_uri,
			'mobile_uri' => $mobile_uri
		);
		
		$this->db->insert('story_page_images', $data);
	}
	
	public function update_page_image($id, $name, $description, $desktop_uri, $mobile_uri) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'desktop_uri' => $desktop_uri,
			'mobile_uri' => $mobile_uri
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_page_images', $data);
	}
	
	public function delete_page_image($id) {
		$this->db->delete('story_page_images', array('id' => $id));
	}
	
	public function get_icons() {
		$query = $this->db->get('story_option_icons');
		return $query->result_array();
	}
	
	public function get_icon($id) {
		$query = $this->db->get_where('story_option_icons', array('id' => $id));
		return $query->row_array();
	}
	
	public function create_icon($name, $description, $desktop_uri, $mobile_uri) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'desktop_uri' => $desktop_uri,
			'mobile_uri' => $mobile_uri
		);
		
		$this->db->insert('story_option_icons', $data);
	}
	
	public function update_icon($id, $name, $description, $desktop_uri, $mobile_uri) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'desktop_uri' => $desktop_uri,
			'mobile_uri' => $mobile_uri
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_option_icons', $data);
	}
	
	public function delete_icon($id) {
		$this->db->delete('story_option_icons', array('id' => $id));
	}
}