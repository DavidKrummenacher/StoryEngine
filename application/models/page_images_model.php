<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_images_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all() {
		$query = $this->db->get('story_page_images');
		return $query->result_array();
	}
	
	public function get($id) {
		$query = $this->db->get_where('story_page_images', array('id' => $id));
		return $query->row_array();
	}
	
	public function create($name, $description, $desktop_uri, $mobile_uri) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'desktop_uri' => $desktop_uri,
			'mobile_uri' => $mobile_uri
		);
		
		$this->db->insert('story_page_images', $data);
	}
	
	public function update($id, $name, $description, $desktop_uri, $mobile_uri) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'desktop_uri' => $desktop_uri,
			'mobile_uri' => $mobile_uri
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_page_images', $data);
	}
	
	public function delete($id) {
		$this->db->delete('story_page_images', array('id' => $id));
	}
}