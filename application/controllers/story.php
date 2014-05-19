<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Story extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->helper('bootstrap_adjustments');
		$this->load->model('settings_model');
		$this->load->model('display_model');
		$this->load->model('story_model');
		$this->load->model('options_model');
		$this->load->model('assets_model');

		$this->lang->load('storyengine');
	}
	
	public function register() {
		$this->data['title'] = "Create User";
		$cover = $this->display_model->get_display_settings('cover_image');
		$this->data['cover_image'] = $this->assets_model->get_page_image($cover);
		//validate form input
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[auth_users.username]');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() == true) {
			$username = $this->input->post('username');
			$email    = strtolower($this->input->post('username'));
			$password = $this->input->post('password');

			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name')
			);
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email)) {
			//check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("page", 'refresh');
		} else {
			//display the create user form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['username'] = array(
				'name'  => 'username',
				'id'    => 'username',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('username'),
			);
			$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['password'] = array(
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->_render_page('story/register', $this->data);
		}
	}
	
	public function login() {
		if ($this->ion_auth->logged_in()) { redirect('page', 'refresh'); }
		
		$this->data['title'] = "Login";
		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		$cover = $this->display_model->get_display_settings('cover_image');
		$this->data['cover_image'] = $this->assets_model->get_page_image($cover);

		if ($this->form_validation->run() == true) {
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('menu/continue_game', 'refresh');
			} else {
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('story/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('story/login', $this->data);
		}
	}

	//log the user out
	public function logout() {
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('story/login', 'refresh');
	}
	
	public function list_pages() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
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
		
		$this->data['pages'] = $this->story_model->get_pages($config['cur_page']*$config['per_page'],$config['per_page']);
		
		//Add Links to data array
        $this->data['pagination'] = create_list($this->pagination);
		
		$this->_render_page('story/list', $this->data);
	}
	
	
	
	public function pages_and_options() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		
		//Prepare PageNodes
		$pages = $this->story_model->get_pages();
		$pages = array_map(function($pages) {
			
			
					return array(
						'label' => utf8_encode($pages['title']),
						'id' => "page".$pages['id'],
						'color' => "rgb(10,10,10)",
						'size' => 4.0,
						'x' => rand($pages['id']/2,$pages['id']),
						'y' => rand($pages['id']/2,$pages['id'])
					);
				}, $pages);
				
				
		
				
		//Prepare OptionNodes		
		$optionnodes = $this->options_model->get_all();
		$optionnodes = array_map(function($optionnodes) {
				
						return array(
							'label' => "Option: ".utf8_encode($optionnodes['text']),
							'id' => "option".$optionnodes['id'],
							'color' => "rgb(180,180,180)",
							'size' => 2.0,
							'x' => rand($optionnodes['source_page']/2,$optionnodes['source_page']),
							'y' => rand($optionnodes['source_page']/2,$optionnodes['source_page'])
							);
					}, $optionnodes);
					
					
	
		$nodes = array_merge($pages,$optionnodes);

		
		//Get Edges / Connections
		$targetedges = $this->story_model->get_optiontargets();
		
		$targetedges = array_map(function($targetedges) {
						return array(
							'source' => "option".$targetedges['option'],
							'target' => "page".$targetedges['target_page'],
							'id' => "targetedge".$targetedges['id']
						);
					}, $targetedges);
					
		$optionedges = 	$this->options_model->get_all();
		
		$optionedges = array_map(function($optionedges) {
						return array(
							'source' => "page".$optionedges['source_page'],
							'target' => "option".$optionedges['id'],
							'id' => "optionedge".$optionedges['id']
							);
					}, $optionedges);
					
		
		$edges = array_merge($targetedges,$optionedges);
		
		$this->output
    	->set_content_type('application/json')
		//set_header('Content-Type:application/json; charset=UTF-8')
  		->set_output(json_encode(array('edges' => $edges,
									   'nodes'=> $nodes)
									)
								);
	
	}
	
	public function page_nodes_only() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//Prepare PageNodes
		$nodes = $this->story_model->get_pages();
		$nodes = array_map(function($nodes) {
		
					return array(
						'label' => utf8_encode($nodes['title']),
						'id' => "page".$nodes['id'],
						'color' => "rgb(10,10,10)",
						'size' => 4.0,
						'x' => rand($nodes['id']/2,$nodes['id']),
						'y' => rand($nodes['id']/2,$nodes['id'])
					);
				}, $nodes);
				
		
		
		//Get Edges / Connections
		
		$edges = $this->options_model->get_direct_connections();
		
		$edges = array_map(function($edges) {
						return array(
							'source' => "page".$edges['source_page'],
							'target' => "page".$edges['target_page'],
							'id' => "No.".$edges['id']."_".$edges['source_page']."_to_".$edges['target_page']
							);
					}, $edges);
					
		
		//Set Color of StartNode
		
		
		$this->output
    	->set_content_type('application/json')
		//set_header('Content-Type:application/json; charset=UTF-8')
  		->set_output(json_encode(array('edges' => $edges,
									   'nodes'=> $nodes)
									)
								);
	
	}

	
	public function overview() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		$this->data['start_page'] = $this->settings_model->get_value('start_page');

		$this->_render_page('story/overview', $this->data);
	}
	
	public function search($term = null) {
    	if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }

		$this->data['results'] = null;
		$term = $this->input->post('searchterm',TRUE);
		
		if ($term != null) { $this->data['results'] = $this->story_model->search_page($term); } 
		else { redirect('story/list_pages/0', 'refresh'); }
		
		$this->_render_page('story/search', $this->data);
	}
	
	public function settings() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		if (!$this->ion_auth->is_admin()) { show_error('You need admin rights to do this!'); }
		
		if ($this->input->post() != null) {
			$p = $this->input->post();
			foreach($p as $key=>$value) {
				if ($key == 'story_title' || $key == 'cover_image') {
					$this->display_model->set_display_setting($key, $value);
				} else {
					$this->settings_model->set_story_setting($key, $value);
				}
			}
			
			$this->data['flash'] = $this->lang->line('settings_saved');
		}
		
		// TODO: Fix settings
		// TODO: Implement settings
		$this->data['settings'] = $this->settings_model->get_story_settings();
		$this->data['story_title'] = $this->display_model->get_display_setting('story_title');
		$this->data['story_cover'] = $this->display_model->get_display_setting('cover_image');
		
		$this->data['icons'] = $this->assets_model->get_icons();
		$this->data['page_images'] = $this->assets_model->get_page_images();
		$this->_render_page('story/settings', $this->data);
	}
	
	public function debug() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		if (!$this->ion_auth->is_author()) { show_error('You need author rights to do this!'); }
		
		$this->load->model('attributes_model');
		$this->data['start_page'] = $this->settings_model->get_value('start_page');
		$this->data['last_page'] = $this->ion_auth->user()->row()->last_page;
		$this->data['attributes'] = $this->attributes_model->get_all();
		$this->data['user_attributes'] = $this->attributes_model->get_all_for_user($this->ion_auth->user()->row()->id);
		$this->_render_page('story/debug', $this->data);
	}
	
	public function debugoptions() {
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); }
		if (!$this->ion_auth->is_author()) { show_error('You need author rights to do this!'); }
		
		$this->data['options'] = $this->options_model->get_lose_connections();

		//$this->load->model('attributes_model');
		
		
		$this->_render_page('story/debugoptions', $this->data);
	}
	
	protected function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}