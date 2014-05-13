<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Display extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->model('display_model');
		
		$this->lang->load('storyengine');
	}
	
	public function index() {
		// echo css
		$this->output
			->set_content_type('text/css')
			->set_output($this->display_model->get_value('css'));
	}
	
	public function edit() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		if (isset($_POST) && !empty($_POST)) {
			$css = $this->input->post('css');
			$this->display_model->set_display_setting('css', $css);
			$this->session->set_flashdata('message', 'CSS saved');
			redirect('display/edit');
		} else {
			$this->data['message'] = $this->session->flashdata('message');
			$this->data['css'] = array(
				'name'  => 'css',
				'id'    => 'css',
				'type'  => 'text',
				'value' => ($this->input->post('css')) ? $this->input->post('css') : $this->display_model->get_value('css'),
			);
			$this->_render_page('display/edit', $this->data);
		}
	}
	
	public function preview() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		$this->_render_page('display/preview');
	}
	
	protected function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}