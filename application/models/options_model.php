<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Options_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all() {
		$query = $this->db->get('story_options');
		return $query->result_array();
	}
	
	public function get_options_for_page($page) {
		$query = $this->db->get_where('story_options', array('source_page' => $page));
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
}