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
	
	public function get_direct_connections() {
		 $this->db->select('*');
		$this->db->from('story_options');
		$this->db->join('story_option_targets', 'story_option_targets.option = story_options.id','inner');
		
		$query = $this->db->get();
		
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
		$this->db->select('
			story_option_conditions.id,
			story_option_conditions.option,
			story_option_conditions.attribute,
			story_option_conditions.comparison,
			story_option_conditions.value,
			story_attributes.id AS attributes_id,
			story_attributes.name AS attribute_name,
			story_attributes.description AS attribute_description,
			story_attributes.value AS attribute_value,
			story_attribute_comparisons.id AS comparison_id,
			story_attribute_comparisons.name AS comparison_name,
			story_attribute_comparisons.description AS comparison_description
		');
		$this->db->join('story_attributes','story_attributes.id = story_option_conditions.attribute');
		$this->db->join('story_attribute_comparisons','story_attribute_comparisons.id = story_option_conditions.comparison');
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
	public function get_targets_for_option($option, $fail = null) {
		$this->db->select('
			story_option_targets.id,
			story_option_targets.option,
			story_option_targets.target_page,
			story_option_targets.fail,
			story_pages.id AS page_id,
			story_pages.title,
			story_pages.description,
			story_pages.content,
			story_pages.image
		');
		$this->db->join('story_pages','story_pages.id = story_option_targets.target_page');
		if ($fail != null)
			$query = $this->db->get_where('story_option_targets', array('option' => $option, 'fail' => $fail));
		else
			$query = $this->db->get_where('story_option_targets', array('option' => $option));
		return $query->result_array();
	}
	public function get_amount_of_targets_for_option($option, $fail = null) {
		if ($fail != null)
			$query = $this->db->get_where('story_option_targets', array('option' => $option, 'fail' => $fail));
		else
			$query = $this->db->get_where('story_option_targets', array('option' => $option));
		return $query->num_rows();
	}
	
	public function get_check($id) {
		$query = $this->db->get_where('story_option_checks', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_checks() {
		$query = $this->db->get('story_option_checks');
		return $query->result_array();
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
		$this->db->select('
			story_option_checks.id,
			story_option_checks.option,
			story_option_checks.attribute,
			story_option_checks.comparison,
			story_option_checks.value,
			story_option_checks.random,
			story_attributes.id AS attributes_id,
			story_attributes.name AS attribute_name,
			story_attributes.description AS attribute_description,
			story_attributes.value AS attribute_value,
			story_attribute_comparisons.id AS comparison_id,
			story_attribute_comparisons.name AS comparison_name,
			story_attribute_comparisons.description AS comparison_description
		');
		$this->db->join('story_attributes','story_attributes.id = story_option_checks.attribute');
		$this->db->join('story_attribute_comparisons','story_attribute_comparisons.id = story_option_checks.comparison');
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
		$this->db->select('
			story_option_consequences.id,
			story_option_consequences.option,
			story_option_consequences.attribute,
			story_option_consequences.operator,
			story_option_consequences.value,
			story_attributes.id AS attributes_id,
			story_attributes.name AS attribute_name,
			story_attributes.description AS attribute_description,
			story_attributes.value AS attribute_value,
			story_attribute_operators.id AS operator_id,
			story_attribute_operators.name AS operator_name,
			story_attribute_operators.description AS operator_description
		');
		$this->db->join('story_attributes','story_attributes.id = story_option_consequences.attribute');
		$this->db->join('story_attribute_operators','story_attribute_operators.id = story_option_consequences.operator');
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
}