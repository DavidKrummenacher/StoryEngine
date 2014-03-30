<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Story_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_pages($start = null, $limit = null) {
		if($limit != null && $start == null) {
        	$this->db->limit($limit);
		} else if ($limit != null && $start != 0) {
	        $this->db->limit($limit, $start);
		}
		$query = $this->db->get('story_pages');
		return $query->result_array();
	}
	
	public function get_pagecount() {
		return $this->db->count_all_results('story_pages');
	}
	
	public function get_relations() {
		$this->db->join('story_options','story_options.id = story_option_targets.option');
		$this->db->join('story_pages','story_pages.id = story_option_targets.target_page');
			
		$query = $this->db->get('story_option_targets');
		
		return $query->result_array();
	}
	
	public function search_page($searchterm) {
		$this->db->like('title',$searchterm);
		$query = $this->db->get('story_pages');
		return $query->result_array();
	}
	
	public function get_search_count($searchterm) {	
		$this->db->like('title', $searchterm);
		$this->db->from('story_pages');
		
		return $this->db->count_all_results();
	}
}