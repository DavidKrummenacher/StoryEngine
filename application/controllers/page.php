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
		$start_page = $this->settings_model->get_value('start_page');
		redirect('page/show/'.$start_page);
	}
	
	public function show($id) {
		$this->data['page'] = $this->pages_model->get_page($id);
		$this->data['options'] = $this->pages_model->get_options($id);
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/view', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
	
	public function create_page() {
		$this->pages_model->create_page('Blah', 'blah blab blah');
		redirect('page/show_all', 'refresh');
	}
	
	public function edit_page($id) {
		
	}
	
	public function delete_page($id) {
		
	}
	
	public function overview() {
		$this->load->view('templates/header');
		$this->load->view('pages/overview');
		$this->load->view('templates/footer');
	}
	
	public function list_all() {
		$this->data['pages'] = $this->pages_model->get_pages();
		
		$this->load->view('templates/header');
		$this->load->view('pages/list', $this->data);
		$this->load->view('templates/footer');
	}
	
	public function search($term = null) {
		$this->data['results'] = null;
		
		if ($term != null) {
			$this->data['results'] = 'Derp';
		}
		
		$this->load->view('templates/header');
		$this->load->view('pages/search', $this->data);
		$this->load->view('templates/footer');
	}
	
	public function settings() {
		$this->load->view('templates/header');
		$this->load->view('pages/settings');
		$this->load->view('templates/footer');
	}
}