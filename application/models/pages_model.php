<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all() {
		$query = $this->db->get('story_pages');
		return $query->result_array();
	}
	
	public function get($id) {
		$query = $this->db->get_where('story_pages', array('id' => $id));
		return $query->row_array();
	}
	
	public function create($title, $description, $content, $page_image) {
		$data = array(
			'title' => $title,
			'description' => $description,
			'content' => $content,
			'image' => ($page_image == 'null') ? null : $page_image
		);
		
		$this->db->insert('story_pages', $data);
		return $this->db->insert_id();
	}
	
	public function update($id, $title, $description, $content, $page_image) {
		$data = array(
			'title' => $title,
			'description' => $description,
			'content' => $content,
			'image' => ($page_image == 'null') ? null : $page_image
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_pages', $data);
	}
	
	public function delete($id) {
		$this->db->delete('story_pages', array('id' => $id));
	}
	
	public function get_consequence($id) {
		$query = $this->db->get_where('story_page_consequences', array('id' => $id));
		return $query->row_array();
	}
	public function create_consequence($page, $attribute, $operator, $value) {
		$data = array(
			'page' => $page,
			'attribute' => $attribute,
			'operator' => $operator,
			'value' => $value
		);
		
		$this->db->insert('story_page_consequences', $data);
	}
	public function update_consequence($id, $attribute, $operator, $value) {
		$data = array(
			'attribute' => $attribute,
			'operator' => $operator,
			'value' => $value
		);
		
		$this->db->where('id', $id);
		$this->db->update('story_page_consequences', $data);
	}
	public function delete_consequence($id) {
		$this->db->delete('story_page_consequences', array('id' => $id));
	}
	public function get_consequences_for_page($page) {
		$this->db->select('
			story_page_consequences.id,
			story_page_consequences.page,
			story_page_consequences.attribute,
			story_page_consequences.operator,
			story_page_consequences.value,
			story_attributes.id AS attributes_id,
			story_attributes.name AS attribute_name,
			story_attributes.description AS attribute_description,
			story_attributes.value AS attribute_value,
			story_attribute_operators.id AS operator_id,
			story_attribute_operators.name AS operator_name,
			story_attribute_operators.description AS operator_description
		');
		$this->db->join('story_attributes','story_attributes.id = story_page_consequences.attribute');
		$this->db->join('story_attribute_operators','story_attribute_operators.id = story_page_consequences.operator');
		$query = $this->db->get_where('story_page_consequences', array('page' => $page));
		return $query->result_array();
	}
}