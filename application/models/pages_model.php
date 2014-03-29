<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends CI_Model {
	
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
	
	
	public function get_page($id) {
		$query = $this->db->get_where('story_pages', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_total_pagecount() {
		return $this->db->count_all_results('story_pages');
		}
	
	public function get_consequences_for_page($id) {
		$query = $this->db->get_where('story_page_consequences', array('page' => $id));
		return $query->result_array();
	}
	
	public function get_options($id) {
		$query = $this->db->get_where('story_options', array('source_page' => $id));
		return $query->result_array();
	}
	
	public function get_conditions_for_option($id) {
		$query = $this->db->get_where('story_option_conditions', array('option' => $id));
		return $query->result_array();
	}
	
	public function get_targets_for_option($id, $fail) {
		$query = $this->db->get_where('story_option_targets', array('option' => $id, 'fail' => $fail));
		return $query->result_array();
	}
	
	public function get_checks_for_option($id) {
		$query = $this->db->get_where('story_option_checks', array('option' => $id));
		return $query->result_array();
	}
	
	public function get_consequences_for_option($id) {
		$query = $this->db->get_where('story_option_consequences', array('option' => $id));
		return $query->result_array();
	}
	
	public function get_targets($id) {
		/*$OptionArray = "";
		
		$i = 0;
		foreach($optionid as $option) {
			$OptionArray[$i] = $option['id'];
			$i++;
			}
		*/
		$this->db->join('story_option_targets','story_option_targets.option = story_options.id');
		$query = $this->db->get_where('story_options',array('source_page' => $id));		
		
		return $query->result_array();
	}
	
	public function get_icons() {
		$query = $this->db->get('story_option_icons');
		
		return $query->result_array();
		}
	
	public function get_relations() {
	
		$this->db->join('story_options','story_options.id = story_option_targets.option');
		$this->db->join('story_pages','story_pages.id = story_option_targets.target_page');
			
		$query = $this->db->get('story_option_targets');
		
		return $query->result_array();
	}
	
	
	
	public function create_page($title, $content, $description = null) {
		$data = array(
			'title' => $title,
			'content' => $content
		);
		if ($description) $data['description'] = $description;
		
		$this->db->insert('story_pages', $data);
	}
	
	public function update_page($id, $title, $content, $description = null) {
		$data = array(
			'title' => $title,
			'content' => $content
		);
		if ($description) $data['description'] = $description;
		
		$this->db->where('id', $id);
		$this->db->update('story_pages', $data);
	}
	
	public function delete_page($id) {
		$this->db->delete('story_pages', array('id' => $id));
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
	
			$this->db->like('title',$searchterm);
			$query = $this->db->get('story_pages');
			return $query->result_array();
		}
	
	public function get_search_count($searchterm)
		{	
			$this->db->like('title', $searchterm);
			$this->db->from('story_pages');			
			
			return $this->db->count_all_results();
		}
	

}