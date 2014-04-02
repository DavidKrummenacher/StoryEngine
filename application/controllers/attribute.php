<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attribute extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->model('attributes_model');
		$this->lang->load('storyengine');
	}
	
	public function index() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		$this->data['message'] = ($this->ion_auth->errors()) ? $this->ion_auth->errors() : $this->session->flashdata('message');
		
		$this->data['attributes'] = $this->attributes_model->get_all();
		$this->_render_page('attributes/list', $this->data);
	}

	public function add() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('name', 'Name', 'required');
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
			
			$this->_render_page('attributes/add', $this->data);
		}
	}
	
	public function edit($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('name', 'Name', 'required');
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
			
			$this->_render_page('attributes/edit', $this->data);
		}
	}
	
	public function delete($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		$this->attributes_model->delete($id);
		redirect('attribute');
	}
	
	protected function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}