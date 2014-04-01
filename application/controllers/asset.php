<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->helper('bootstrap_adjustments');
		$this->load->model('settings_model');
		$this->load->model('attributes_model');
		$this->load->model('pages_model');
		$this->load->model('options_model');
		
		$this->lang->load('storyengine');
	}
	
	public function index() {
		// List
	}
	
	public function add_page_image() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		//$this->form_validation->set_rules('order', 'Order', 'required');
		//$this->form_validation->set_rules('text', 'Text', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->_render_page('assets/icons/add', $this->data);
		}
	}
	public function edit_page_image($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		//$this->form_validation->set_rules('order', 'Order', 'required');
		//$this->form_validation->set_rules('text', 'Text', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->_render_page('assets/icons/edit', $this->data);
		}
	}
	public function delete_page_image($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
	}
	
	public function add_icon() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		//$this->form_validation->set_rules('order', 'Order', 'required');
		//$this->form_validation->set_rules('text', 'Text', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->_render_page('assets/icons/add', $this->data);
		}
	}
	public function edit_icon($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		//$this->form_validation->set_rules('order', 'Order', 'required');
		//$this->form_validation->set_rules('text', 'Text', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->_render_page('assets/icons/edit', $this->data);
		}
	}
	public function delete_icon($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
	}
	
	function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}