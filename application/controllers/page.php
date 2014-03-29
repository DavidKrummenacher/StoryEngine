<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('pagination');
		$this->load->helper('text');
		$this->load->helper('bootstrap_adjustments');
		$this->load->model('settings_model');
		$this->load->model('pages_model');
		
		$this->lang->load('storyengine');
	}
	
	public function index() {
		// Redirect to start page
		$start_page = $this->settings_model->get_value('start_page');
		redirect('page/show/'.$start_page);
	}
	
	public function show($id) {
		// TODO: Implement page handling
		// TODO: Achievemnt unlocking
		$this->data['page'] = $this->pages_model->get_page($id);
		$this->data['image'] = $this->pages_model->get_page_image($this->data['page']['image']);
		
		// Apply consequences (story_page_consequences)
		$consequences = $this->pages_model->get_consequences_for_page($id);
		foreach ($consequences as $consequence) { _apply_consequences($consequence); }
		
		// Option filtering
		$options = array();
		$options_for_page = $this->pages_model->get_options($id);
		foreach ($options_for_page as $option) {
			$conditions = $this->pages_model->get_conditions_for_option($option['id']);
			
			$conditions_met = true;
			foreach ($conditions as $condition) {
				// TODO: Check conditions
				// Check conditions
				
				
				if (!$conditions_met) { break; }
			}
			
			if ($conditions_met) { array_push($options, $option); }
		}
		$this->data['options'] = $options;
		
		$this->_render_page('pages/view', $this->data);
	}
	
	public function option($id) {
		// TODO: Implement option handling
		// Roll (story_option_rolls)
		$success = true;
		$checks = $this->pages_model->get_checks_for_option($id);
		foreach ($checks as $check) {
			// TODO: Check for failure
			// Check for failure
			
			
			if (!success) { break; }
		}
		
		// Choose random page based on success (story_option_targets)
		$targets = $this->pages_model->get_targets_for_option($id, !$success);
		$target = $targets[array_rand($targets)];
		
		// Apply consequences (story_option_consequences)
		$consequences = $this->pages_model->get_consequences_for_option($id);
		foreach ($consequences as $consequence) { _apply_consequences($consequence); }
		
		// Redirect to page
		redirect('page/show/'.$target['target_page']);
	}
	
	private function _apply_consequences($consequence) {
		// TODO: Apply consequences
		
	}
	
	public function create_page() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		// TODO: Implement redirect to new page in edit mode
		$this->pages_model->create_page('Blah', 'blah blab blah');
		redirect('page/show_all', 'refresh');
	}
	
	public function edit_page($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		// TODO: Implement update
		$this->data['page'] = $this->pages_model->get_page($id);
		$this->data['options'] = $this->pages_model->get_options($id);
		$this->data['icons'] = $this->pages_model->get_icons();
		$this->data['targets'] = $this->pages_model->get_targets($id);
		$this->_render_page('pages/edit_page',$this->data);

	}
	
	public function delete_page($id) {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		if ($id == $this->settings_model->get_value('start_page')) { show_error('You cannot delete the current start page.'); }
		
		// Delete image on server
		$page = $this->pages_model->get_page($id);
		$image = $this->pages_model->get_page_image($page['image']);
		if ($image) {
			if (file_exists('../img/desktop/'.$image['desktop_uri'])) { unlink ('../img/desktop/'.$image['desktop_uri']); }
			if (file_exists('../img/mobile/'.$image['mobile_uri'])) { unlink ('../img/mobile/'.$image['mobile_uri']); }
		}
		
		// Delete page
		$this->pages_model->delete_page($id);
		
		redirect('page/list_all', 'refresh');
	}
	
	public function overview() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		// TODO: Implement overview
		$this->data['relations'] = $this->pages_model->get_relations();
		
		$this->_render_page('pages/overview',$this->data);
	}
	
	public function list_all() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		
		// TODO: Grab "per_page" config-var from ADMIN-settings instead of story_settings
		//Pagination configs
		$config = array();
        $config['base_url'] = base_url() . "index.php/page/list_all";
        $config['total_rows'] = $this->pages_model->get_total_pagecount();
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
		
		
		$this->data['pages'] = $this->pages_model->get_pages($config['cur_page'],$config['per_page']);
		
		//Add Links to data array

        $this->data['pagination'] = create_list($this->pagination);
 
		
		$this->load->view('templates/header');
		$this->load->view('pages/list', $this->data);
		$this->load->view('templates/footer');
	}
	
	
	public function search($term = null) {
    if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }

		$this->data['results'] = null;
		$term = $this->input->post('searchterm',TRUE);
		
		if ($term != null) {
			$this->data['results'] = $this->pages_model->search_page($term);
		} else {
			redirect('page/list_all', 'refresh');
		}
		
		$this->load->view('templates/header');
		$this->load->view('pages/search', $this->data);
		$this->load->view('templates/footer');
	}
	
	
	public function settings() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		if (!$this->ion_auth->is_admin()) { show_error('You need admin rights to do this!'); }
		
		if ($this->input->post() != null)
			{
			$p = $this->input->post();
			foreach($p as $key=>$value)
				{   
					$this->settings_model->set_story_setting($key,$value);
				}
				
			$this->data['flash'] = $this->lang->line('settings_saved');
			}
		
		// TODO: Fix settings
		// TODO: Implement settings
		$this->data['settings'] = $this->settings_model->get_story_settings();
		$this->_render_page('pages/settings', $this->data);
	}
	
	function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}