<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->helper('text');
		$this->load->model('settings_model');
		$this->load->model('pages_model');
		
		$this->lang->load('storyengine');
	}
	
	public function index() {
		// Redirect to start page
		$start_page = $this->settings_model->get_value('start_page');
		redirect('page/show/'.$start_page);
	}
	
	public function show($id) {
		// TODO: Implement page handling
		// TODO: Implement option filtering (story_options_conditions), maybe inside pages_model
		$this->data['page'] = $this->pages_model->get_page($id);
		$this->data['options'] = $this->pages_model->get_options($id);
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/view', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
	
	public function option($id) {
		// TODO: Implement option handling
		// Roll (story_option_rolls)
		// Choose random page based on success (story_option_targets)
		// Apply consequences (story_option_consequences)
		// Redirect to page
	}
	
	public function create_page() {
		// TODO: Implement redirect to new page in edit mode
		$this->pages_model->create_page('Blah', 'blah blab blah');
		redirect('page/show_all', 'refresh');
	}
	
	public function edit_page($id) {
		// TODO: Implement update
	}
	
	public function delete_page($id) {
		// TODO: Implement delete
	}
	
	public function overview() {
		// TODO: Implement overview
		$this->load->view('templates/header');
		$this->load->view('pages/overview');
		$this->load->view('templates/footer');
	}
	
	public function list_all() {
		// TODO: Implement pagination and searching
		$this->data['pages'] = $this->pages_model->get_pages();
		
		$this->load->view('templates/header');
		$this->load->view('pages/list', $this->data);
		$this->load->view('templates/footer');
	}
	
	public function search($term = null) {
		// TODO: Implement searching
		$this->data['results'] = null;
		
		if ($term != null) {
			$this->data['results'] = 'Derp';
		}
		
		$this->load->view('templates/header');
		$this->load->view('pages/search', $this->data);
		$this->load->view('templates/footer');
	}
	
	public function settings() {
		// TODO: Fix settings
		// TODO: Implement settings
		$this->load->view('templates/header');
		$this->load->view('pages/settings');
		$this->load->view('templates/footer');
	}
}