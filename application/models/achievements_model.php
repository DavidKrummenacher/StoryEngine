<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Achievements_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all() {
		$this->db->select('
			story_achievements.id,
			story_achievements.name,
			story_achievements.description,
			story_achievements.desktop_uri,
			story_achievements.mobile_uri,
			story_achievements.attribute,
			story_achievements.comparison,
			story_achievements.value,
			story_attributes.id AS attributes_id,
			story_attributes.name AS attribute_name,
			story_attributes.description AS attribute_description,
			story_attributes.value AS attribute_value,
			story_attribute_comparisons.id AS comparison_id,
			story_attribute_comparisons.name AS comparison_name,
			story_attribute_comparisons.description AS comparison_description
		');
		$this->db->join('story_attributes','story_attributes.id = story_achievements.attribute');
		$this->db->join('story_attribute_comparisons','story_attribute_comparisons.id = story_achievements.comparison');
		$query = $this->db->get('story_achievements');
		return $query->result_array();
	}
	
	public function get($id) {
		$this->db->select('
			story_achievements.id,
			story_achievements.name,
			story_achievements.description,
			story_achievements.desktop_uri,
			story_achievements.mobile_uri,
			story_achievements.attribute,
			story_achievements.comparison,
			story_achievements.value,
			story_attributes.id AS attributes_id,
			story_attributes.name AS attribute_name,
			story_attributes.description AS attribute_description,
			story_attributes.value AS attribute_value,
			story_attribute_comparisons.id AS comparison_id,
			story_attribute_comparisons.name AS comparison_name,
			story_attribute_comparisons.description AS comparison_description
		');
		$this->db->join('story_attributes','story_attributes.id = story_achievements.attribute');
		$this->db->join('story_attribute_comparisons','story_attribute_comparisons.id = story_achievements.comparison');
		$query = $this->db->get_where('story_achievements', array('story_achievements.id' => $id));
		return $query->row_array();
	}
	
	public function create($name, $description, $desktop_uri, $mobile_uri, $attribute, $comparison, $value) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'desktop_uri' => $desktop_uri,
			'mobile_uri' => $mobile_uri,
			'attribute' => $attribute,
			'comparison' => $comparison,
			'value' => $value
		);
		
		$this->db->insert('story_achievements', $data);
	}
	
	public function update($id, $name, $description, $desktop_uri, $mobile_uri, $attribute, $comparison, $value) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'desktop_uri' => $desktop_uri,
			'mobile_uri' => $mobile_uri,
			'attribute' => $attribute,
			'comparison' => $comparison,
			'value' => $value
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_achievements', $data);
	}
	
	public function delete($id) {
		$this->db->delete('story_achievements', array('id' => $id));
	}

	public function get_all_for_user($user) {
		$query = $this->db->get_where('story_users_achievements', array('user' => $user));
		return $query->result_array();
	}
	
	public function get_for_user($user, $id) {
		$query = $this->db->get_where('story_users_achievements', array('user' => $user, 'achievement' => $id));
		return $query->row_array();
	}
	
	public function set_for_user($user, $id) {
		$data = array(
			'user' => $user,
			'attribute' => $id
		);
		
		$this->db->insert('story_users_achievements', $data);
	}
}