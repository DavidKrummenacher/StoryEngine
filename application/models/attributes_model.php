<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attributes_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all() {
		$query = $this->db->get('story_attributes');
		return $query->result_array();
	}
	
	public function get($id) {
		$query = $this->db->get_where('story_attributes', array('id' => $id));
		return $query->row_array();
	}
	
	public function create($name, $description, $value) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'value' => $value
		);
		
		$this->db->insert('story_attributes', $data);
	}
	
	public function update($id, $name, $description, $value) {
		$data = array(
			'name' => $name,
			'description' => $description,
			'value' => $value
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_attributes', $data);
	}
	
	public function delete($id) {
		$this->db->delete('story_attributes', array('id' => $id));
	}
	
	public function get_attribute_comparisons() {
		$query = $this->db->get('story_attribute_comparisons');
		return $query->result_array();
	}
	
	public function get_attribute_comaprison($id) {
		$query = $this->db->get_where('story_attribute_comaparisons', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_attribute_operators() {
		$query = $this->db->get('story_attribute_operators');
		return $query->result_array();
	}
	
	public function get_attribute_operator($id) {
		$query = $this->db->get_where('story_attribute_operators', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_all_for_user($user) {
		$query = $this->db->get_where('story_users_attributes', array('user' => $user));
		return $query->result_array();
	}
	
	public function get_for_user($user, $id) {
		$query = $this->db->get_where('story_users_attributes', array('user' => $user, 'attribute' => $id));
		
		// Set to default value if not set
		if ($query->num_rows() <= 0) {
			$this->create_for_user($user, $id);
			$query = $this->db->get_where('story_users_attributes', array('user' => $user, 'attribute' => $id));
		}
		
		return $query->row_array();
	}
	
	public function create_for_user($user, $id) {
		$value = $this->get($id);
		$data = array(
			'user' => $user,
			'attribute' => $id,
			'value' => $value['value']
		);
		
		$this->db->insert('story_users_attributes', $data);
	}
	
	public function update_for_user($user, $id, $value) {
		$data = array(
			'value' => $value
		);
		
		$this->db->where('user', $user);
		$this->db->where('attribute', $id);
		$this->db->update('story_users_attributes', $data);
	}
	
	public function delete_for_user($user, $id) {
		$this->db->delete('story_users_attributes', array('user' => $user, 'attribute' => $id));
	}
}