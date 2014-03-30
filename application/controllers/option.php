<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Option extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->helper('bootstrap_adjustments');
		$this->load->model('settings_model');
		$this->load->model('options_model');
		
		$this->lang->load('storyengine');
	}
	
	public function index() {
		// Codeigniter wont take parameters on inedx function :(
		show_error('Herp Derp');
	}
	
	public function choose($id) {
		// TODO: Implement option handling
		// Roll (story_option_rolls)
		$success = true;
		$checks = $this->options_model->get_checks_for_option($id);
		foreach ($checks as $check) {
			// TODO: Check for failure
			// Check for failure
			
			
			if (!success) { break; }
		}
		
		// Choose random page based on success (story_option_targets)
		$targets = $this->options_model->get_targets_for_option($id, !$success);
		$target = $targets[array_rand($targets)];
		
		// TODO: Apply consequences (story_option_consequences)
		$consequences = $this->options_model->get_consequences_for_option($id);
		foreach ($consequences as $consequence) { /*_apply_consequences($consequence);*/ }
		
		// Redirect to page
		redirect('page/show/'.$target['target_page']);
	}

	public function add($page) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('order', 'Order', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$order = $this->input->post('order');
			$icon = $this->input->post('icon');
			$text = $this->input->post('text');
			
			$id = $this->options_model->create($page, $order, $icon, $text);
			redirect('option/edit/'.$id);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->data['order'] = array(
				'name'  => 'order',
				'id'    => 'order',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('order'),
			);
			$this->data['icon'] = array(
				'name'  => 'icon',
				'id'    => 'icon',
				'type'  => 'text',
				'value' => $this->input->post('icon'),
			);
			$this->data['text'] = array(
				'name'  => 'text',
				'id'    => 'text',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('text'),
			);
			
			$this->_render_page('options/add', $this->data);
		}
	}
	public function edit($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('order', 'Order', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$order = $this->input->post('order');
			$icon = $this->input->post('icon');
			$text = $this->input->post('text');
			
			$this->options_model->update($id, $order, $icon, $text);
			$option = $this->options_model->update($id);
			redirect('page/edit/'.$option['source_page']);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$option = $this->options_model->get($id);
			$this->data['option'] = $option;
			
			$this->data['order'] = array(
				'name'  => 'order',
				'id'    => 'order',
				'type'  => 'text',
				'value' => ($this->input->post('order')) ? $this->input->post('order') : $option['order'],
			);
			$this->data['icon'] = array(
				'name'  => 'icon',
				'id'    => 'icon',
				'type'  => 'text',
				'value' => ($this->input->post('icon')) ? $this->input->post('icon') : $option['icon'],
			);
			$this->data['text'] = array(
				'name'  => 'text',
				'id'    => 'text',
				'type'  => 'text',
				'value' => ($this->input->post('text')) ? $this->input->post('text') : $option['text'],
			);
			
			$this->_render_page('options/edit', $this->data);
		}
	}
	public function delete($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		$option = $this->options_model->get($id);
		$page = $option['source_page'];
		
		$this->options_model->delete($id);
		redirect('edit/page/'.$page);
	}
	
	public function add_condition() {}
	public function edit_condition() {}
	public function delete_condition() {}
	
	public function add_target() {}
	public function edit_target() {}
	public function delete_target() {}
	
	public function add_check() {}
	public function edit_check() {}
	public function delete_check() {}
	
	public function add_consequence() {}
	public function edit_consequence() {}
	public function delete_consequence() {}
	
	public function add_icon() {}
	public function edit_icon() {}
	public function delete_icon() {}
	
	function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}