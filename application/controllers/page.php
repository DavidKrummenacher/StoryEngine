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
		// TODO: Achievemnt unlocking
		$this->data['page'] = $this->pages_model->get_page($id);
		$this->data['options'] = $this->pages_model->get_options($id);
		
		$this->_render_page('pages/view', $this->data);
	}
	
	public function option($id) {
		// TODO: Implement option handling
		// Roll (story_option_rolls)
		// Choose random page based on success (story_option_targets)
		// Apply consequences (story_option_consequences)
		// Redirect to page
	}
	
	public function create_page() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }

		// TODO: Implement redirect to new page in edit mode
		$this->pages_model->create_page('Blah', 'blah blab blah');
		redirect('page/show_all', 'refresh');
	}
	
	public function edit_page($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		// TODO: Implement update
	}
	
	public function delete_page($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		// TODO: Implement delete
	}
	
	public function overview() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		// TODO: Implement overview
		$this->data['relations'] = $this->pages_model->get_relations();
		
		$this->_render_page('pages/overview',$this->data);
	}
	
	public function list_all() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		// TODO: Implement pagination and searching
		$this->data['pages'] = $this->pages_model->get_pages();
		
		$this->_render_page('pages/list', $this->data);
	}
	
	
	public function search($term = null) {

		$this->data['results'] = null;
		$term = $this->input->post('searchterm',TRUE);
		
		if ($term != null) {
			$this->data['results'] = $this->pages_model->search_page($term);
		} else {
			redirect('page/list_all', 'refresh');
		}
		
		$this->load->view('templates/header');
		$this->load->view('pages/search', $this->data);
		$this->load->view('templates/footer');
	}
	
	
	public function settings() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		if (!$this->ion_auth->is_admin()) { show_error('You need admin rights to do this!'); }
		
		// TODO: Fix settings
		// TODO: Implement settings
		$this->data['settings'] = null; // Dummy data to prevent php error
		$this->_render_page('pages/settings', $this->data);
	}
	
	function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}