<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_pages() {
		$query = $this->db->get('story_pages');
		return $query->result_array();
	}
	
	public function get_page($id) {
		$query = $this->db->get_where('story_pages', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_options($id) {
		$query = $this->db->get_where('story_options', array('source' => $id));
		return $query->result_array();
	}
	
	public function create_page($title, $content) {
		$data = array(
			'title' => $title,
			'content' => $content
		);
		
		$this->db->insert('story_pages', $data);
	}
	
	public function update_page($id, $tite, $content) {
		$data = array(
			'title' => $title,
			'content' => $content
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_pages', $data);
	}
	
	public function delete_page($id) {
		$this->db->delete('story_images', array('page' => $id));
		$this->db->delete('story_options', array('from' => $id));
		$this->db->delete('story_pages', array('id' => $id));
	}
	
	public function delete_all() {
		$this->db->empty_table('story_images');
		$this->db->empty_table('story_options');
		$this->db->empty_table('story_pages');
	}
}