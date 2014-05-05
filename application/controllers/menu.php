<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->model('settings_model');
		
		$this->lang->load('storyengine');
	}
	
	public function new_game() {
		if (!$this->ion_auth->logged_in()) { redirect('story/login', 'refresh'); }
		
		// TODO: Reset attributes
		
		// Load start page
		$start_page = $this->settings_model->get_value('start_page');
		redirect('page/show/'.$start_page);
	}
	
	public function continue_game() {
		if (!$this->ion_auth->logged_in()) { redirect('story/login', 'refresh'); }
		
		// TODO: Load attributes
		$last_page = 1;
		redirect('page/show/'.$last_page);
	}
}