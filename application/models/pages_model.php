<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all() {
		$query = $this->db->get('story_pages');
		return $query->result_array();
	}
	
	public function get($id) {
		$query = $this->db->get_where('story_pages', array('id' => $id));
		return $query->row_array();
	}
	
	public function create($title, $description, $content) {
		$data = array(
			'title' => $title,
			'description' => $description,
			'content' => $content
		);
		
		$this->db->insert('story_pages', $data);
		return $this->db->insert_id();
	}
	
	public function update($id, $title, $description, $content) {
		$data = array(
			'title' => $title,
			'description' => $description,
			'content' => $content
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_pages', $data);
	}
	
	public function delete($id) {
		$this->db->delete('story_pages', array('id' => $id));
	}
	
	public function get_consequences($page) {
		$query = $this->db->get_where('story_page_consequences', array('page' => $page));
		return $query->result_array();
	}
}