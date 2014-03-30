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
	
	public function get($id) {
		$query = $this->db->get_where('story_options', array('id' => $id));
		return $query->row_array();
	}
	public function create($page, $order, $icon, $text) {
		$data = array(
			'source_page' => $page,
			'order' => $order,
			'icon' => $icon,
			'text' => $text
		);
		
		$this->db->insert('story_options', $data);
		return $this->db->insert_id();
	}
	public function update($id, $order, $icon, $text) {
		$data = array(
			'order' => $order,
			'icon' => $icon,
			'text' => $text
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_options', $data);
	}
	public function delete($id) {
		$this->db->delete('story_options', array('id' => $id));
	}
	
	public function get_condition($id) {
		$query = $this->db->get_where('story_option_conditions', array('id' => $id));
		return $query->row_array();
	}
	public function create_condition($option, $attribute, $comparison, $value) {
		$data = array(
			'option' => $option,
			'attribute' => $attribute,
			'comparison' => $comparison,
			'value' => $value
		);
		
		$this->db->insert('story_option_conditions', $data);
	}
	public function update_condition($id, $attribute, $comparison, $value) {
		$data = array(
			'attribute' => $attribute,
			'comparison' => $comparison,
			'value' => $value
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_option_conditions', $data);
	}
	public function delete_condition($id) {
		$this->db->delete('story_option_conditions', array('id' => $id));
	}
	public function get_conditions_for_option($option) {
		$query = $this->db->get_where('story_option_conditions', array('option' => $option));
		return $query->result_array();
	}
	
	public function get_target($id) {
		$query = $this->db->get_where('story_option_targets', array('id' => $id));
		return $query->row_array();
	}
	public function create_target($option, $target_page, $fail) {
		$data = array(
			'option' => $option,
			'target_page' => $target_page,
			'fail' => $fail
		);
		
		$this->db->insert('story_option_targets', $data);
	}
	public function update_target($id, $target_page, $fail) {
		$data = array(
			'target_page' => $target_page,
			'fail' => $fail
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_option_targets', $data);
	}
	public function delete_target($id) {
		$this->db->delete('story_option_targets', array('id' => $id));
	}
	public function get_targets_for_option($option, $fail) {
		$query = $this->db->get_where('story_option_targets', array('option' => $option, 'fail' => $fail));
		return $query->result_array();
	}
	
	public function get_check($id) {
		$query = $this->db->get_where('story_option_checks', array('id' => $id));
		return $query->row_array();
	}
	public function create_check($option, $attribute, $comparison, $value, $random) {
		$data = array(
			'option' => $option,
			'attribute' => $attribute,
			'comparison' => $comparison,
			'value' => $value,
			'random' => $random
		);
		
		$this->db->insert('story_option_checks', $data);
	}
	public function update_check($id, $attribute, $comparison, $value, $random) {
		$data = array(
			'attribute' => $attribute,
			'comparison' => $comparison,
			'value' => $value,
			'random' => $random
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_option_checks', $data);
	}
	public function delete_check($id) {
		$this->db->delete('story_option_checks', array('id' => $id));
	}
	public function get_checks_for_option($option) {
		$query = $this->db->get_where('story_option_checks', array('option' => $option));
		return $query->result_array();
	}
	
	public function get_consequence($id) {
		$query = $this->db->get_where('story_option_consequences', array('id' => $id));
		return $query->row_array();
	}
	public function create_consequence($option, $attribute, $operator, $value) {
		$data = array(
			'option' => $option,
			'attribute' => $attribute,
			'operator' => $operator,
			'value' => $value
		);
		
		$this->db->insert('story_option_consequences', $data);
	}
	public function update_consequence($id, $attribute, $operator, $value) {
		$data = array(
			'attribute' => $attribute,
			'operator' => $operator,
			'value' => $value
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_option_consequences', $data);
	}
	public function delete_consequence($id) {
		$this->db->delete('story_option_consequences', array('id' => $id));
	}
	public function get_consequences_for_option($option) {
		$query = $this->db->get_where('story_option_consequences', array('option' => $option));
		return $query->result_array();
	}
	
	// TODO: Implement option icon CRUD
	
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