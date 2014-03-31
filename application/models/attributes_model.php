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
}