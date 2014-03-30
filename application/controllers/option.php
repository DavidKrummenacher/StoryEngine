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

	public function add() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		/*$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('value', 'Default value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$value = $this->input->post('value');
			
			$this->attributes_model->create($name, $description, $value);
			redirect('attribute');
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->data['name'] = array(
				'name'  => 'name',
				'id'    => 'name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->input->post('description'),
			);
			$this->data['value'] = array(
				'name'  => 'value',
				'id'    => 'value',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('value'),
			);
			
			$this->_render_page('options/add', $this->data);
		}*/
	}
	
	public function edit($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		/*$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('value', 'Default value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$value = $this->input->post('value');
			
			$this->attributes_model->update($id, $name, $description, $value);
			redirect('attribute');
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$attribute = $this->attributes_model->get($id);
			$this->data['attribute'] = $attribute;
			
			$this->data['name'] = array(
				'name'  => 'name',
				'id'    => 'name',
				'type'  => 'text',
				'value' => ($this->input->post('name')) ? $this->input->post('name') : $attribute['name'],
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => ($this->input->post('description')) ? $this->input->post('description') : $attribute['description'],
			);
			$this->data['value'] = array(
				'name'  => 'value',
				'id'    => 'value',
				'type'  => 'text',
				'value' => ($this->input->post('value')) ? $this->input->post('value') : $attribute['value'],
			);
			
			$this->_render_page('options/edit', $this->data);
		}*/
	}
	
	public function delete($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		$option = $this->options_model->get($id);
		$page = $option['source_page'];
		
		$this->options_model->delete($id);
		redirect('edit/page/'.$page);
	}
	
	function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}