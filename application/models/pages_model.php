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
		// TODO: Implement option filtering
		$query = $this->db->get_where('story_options', array('source_page' => $id));
		return $query->result_array();
	}
	
	public function get_relations() {
		$this->db->select('*');
		
		$this->db->from('story_option_targets');
		$this->db->join('story_options','story_options.id == story_option_targets.option');
		$this->db->join('story_pages','story_pages.id = story_option_targets.target_page');
		

		
		$query = $this->db->get();
		
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
		$this->db->empty_table('story_page_images');
		// TODO: Delete images
		$this->db->empty_table('story_option_icons');
		// TODO: Delete icons
		$this->db->empty_table('story_option_conditions');
		$this->db->empty_table('story_option_rolls');
		$this->db->empty_table('story_option_targets');
		$this->db->empty_table('story_option_consequences');
		$this->db->empty_table('story_options');
		$this->db->empty_table('story_pages');
	}
	
	public function search_page($searchterm)
		{
			$this->db->select('*');
			
			$this->db->from('story_pages');
			$this->db->like('title',$searchterm);
			
			$query = $this->db->get();
			return $query->result_array();
		}
	
	public function get_search_count($searchterm)
		{
			$this->db-select('COUNT(id) ss cnt');
			$this->db->from('story_pages');
			$this->db->like('title',$searchterm);
			
			$query = $this->db->get();
			return $query->row_array();
		}
		
	
}