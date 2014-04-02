<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Story extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->helper('bootstrap_adjustments');
		$this->load->model('settings_model');
		$this->load->model('story_model');
		$this->load->model('options_model');
		
		$this->lang->load('storyengine');
	}
	
	public function list_pages() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		// TODO: Grab "per_page" config-var from ADMIN-settings instead of story_settings
		//Pagination configs
		$config = array();
        $config['base_url'] = base_url() . "index.php/story/list_pages";
        $config['total_rows'] = $this->story_model->get_pagecount();
        $config['per_page'] =  ($this->settings_model->get_story_settings('pages_per_page') != FALSE) ? $this->settings_model->get_story_settings('pages_per_page') : 10;
        $config['uri_segment'] = 3;
		
		
		$config['first_link']  = FALSE;
		$config['last_link'] = FALSE;
		$config['next_link'] = FALSE;
		$config['prev_link']  = FALSE;
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		//get current page
		$config['cur_page'] = ($this->uri->segment($config["uri_segment"])) ? $this->uri->segment($config["uri_segment"]) : 0;
		
 		//Ini pagination lib
        $this->pagination->initialize($config);
		
		$this->data['pages'] = $this->story_model->get_pages($config['cur_page'],$config['per_page']);
		
		//Add Links to data array
        $this->data['pagination'] = create_list($this->pagination);
		
		$this->_render_page('story/list', $this->data);
	}
	
	public function overview() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		// TODO: Implement overview
		$this->data['options'] = $this->options_model->get_all();
		$this->data['optiontargets'] = $this->story_model->get_optiontargets();
		$this->data['optionchecks'] = $this->story_model->get_optionchecks();
		$this->data['optionconditions'] = $this->story_model->get_optionconditions();
		$this->data['optionconsequences'] = $this->story_model->get_optionconsequences();
		$this->data['pages'] = $this->story_model->get_pages();
		//$this->data['relations'] = $this->story_model->get_relations();
		
		$this->_render_page('story/overview', $this->data);
	}
	
	public function search($term = null) {
    	if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }

		$this->data['results'] = null;
		$term = $this->input->post('searchterm',TRUE);
		
		if ($term != null) { $this->data['results'] = $this->story_model->search_page($term); }
		else { redirect('page/list_all', 'refresh'); }
		
		$this->_render_page('story/search', $this->data);
	}
	
	public function settings() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		if (!$this->ion_auth->is_admin()) { show_error('You need admin rights to do this!'); }
		
		if ($this->input->post() != null) {
			$p = $this->input->post();
			foreach($p as $key=>$value) {   
				$this->settings_model->set_story_setting($key,$value);
			}
			
			$this->data['flash'] = $this->lang->line('settings_saved');
		}
		
		// TODO: Fix settings
		// TODO: Implement settings
		$this->data['settings'] = $this->settings_model->get_story_settings();
		$this->_render_page('story/settings', $this->data);
	}
	
	protected function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}