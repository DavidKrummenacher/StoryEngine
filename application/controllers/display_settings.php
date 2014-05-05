<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DisplaySettings extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->model('settings_model');
		
		$this->lang->load('storyengine');
	}
	
	public function index() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		/*if ($this->input->post() != null) {
			$p = $this->input->post();
			foreach($p as $key=>$value) {   
				$this->settings_model->set_story_setting($key,$value);
			}
			
			$this->data['flash'] = $this->lang->line('settings_saved');
		}
		
		// TODO: Fix settings
		// TODO: Implement settings
		$this->data['settings'] = $this->settings_model->get_story_settings();
		$this->_render_page('story/settings', $this->data);*/
	}
	
	public function preview() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
	}
	
	protected function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}