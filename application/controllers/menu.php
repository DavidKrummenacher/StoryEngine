<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->model('settings_model');
		$this->load->model('attributes_model');
		
		$this->lang->load('storyengine');
	}
	
	public function new_game() {
		if (!$this->ion_auth->logged_in()) { redirect('story/login', 'refresh'); }
		
		// Reset attributes
		$user = $this->ion_auth->user()->row()->id;
		$user_attributes = $this->attributes_model->get_all_for_user($user);
		foreach($user_attributes as $user_attribute) {
			$attribute = $user_attribute['attribute'];
			$value = $this->attributes_model->get($attribute);
			$value = $value['value'];
			
			$this->attributes_model->update_for_user($user, $attribute, $value);
		}
		
		// Load start page
		$start_page = $this->settings_model->get_value('start_page');
		redirect('page/show/'.$start_page);
	}
	
	public function continue_game() {
		if (!$this->ion_auth->logged_in()) { redirect('story/login', 'refresh'); }
		
		// Load last page
		$this->session->set_flashdata('loaded', true);
		$last_page = $this->ion_auth->user()->row()->last_page;
		redirect('page/show/'.$last_page);
	}
}