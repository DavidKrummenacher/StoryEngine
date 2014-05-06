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
		echo $this->display_model->get_value('css');
	}
	
	public function edit() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		$this->data['message'] = 'Derp';
		$this->data['css'] = $this->display_model->get_value('css');
		$this->_render_page('display/edit', $this->data);
	}
	
	public function preview() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		$this->_render_page('display/preview', $this->data);
	}
	
	protected function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}