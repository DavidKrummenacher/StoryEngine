<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset extends CI_Controller {
	
	protected $dir_icons_desktop;
	protected $dir_icons_mobile;
	protected $icons_width_desktop;
	protected $icons_width_mobile;
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->model('settings_model');
		$this->load->model('achievements_model');
		
		$this->lang->load('storyengine');
		
		$this->dir_icons_desktop = './assets/achievements/desktop/';
		$this->dir_icons_mobile = './assets/achievements/mobile/';
		$this->icons_width_desktop = 48; // TODO: Fix width, maybe with settings
		$this->icons_width_mobile = 32; // TODO: Fix width, maybe with settings
	}
	
	public function index() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		$this->data['message'] = ($this->ion_auth->errors()) ? $this->ion_auth->errors() : $this->session->flashdata('message');
		
		$this->data['achievements'] = $this->achievements_model->get_all();
		$this->_render_page('achievements/list', $this->data);
	}
	
	protected function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}