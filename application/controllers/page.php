<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->model('settings_model');
		$this->load->model('pages_model');
		$this->load->model('assets_model');
		$this->load->model('attributes_model');
		$this->load->model('achievements_model');
		$this->load->model('options_model');
		$this->load->library('user_agent');
		
		$this->lang->load('storyengine');
	}
	
	public function index() {
		// If not logged in redirect to login page
		if (!$this->ion_auth->logged_in()) { redirect('story/login', 'refresh'); }
		
		// Redirect to start page
		$start_page = $this->settings_model->get_value('start_page');
		redirect('page/show/'.$start_page);
	}
	
	public function show($id) {
		if (!$this->ion_auth->logged_in()) { redirect('story/login', 'refresh'); }
		
		$this->data['page'] = $this->pages_model->get($id);
		$this->data['image'] = ($this->data['page'] != null) ? $this->assets_model->get_page_image($this->data['page']['image']) : null;
		$user = $this->ion_auth->user()->row()->id;
		
		//Get UserAgent
		if ($this->agent->is_browser()) {
			$device = 'desktop';
		} elseif ($this->agent->is_robot()) {
			$device = 'desktop';
		} elseif ($this->agent->is_mobile()) {
			$device = 'mobile';
		} else {
			$device = 'desktop';
		}
		
		$this->data['device'] = $device;
		
		// Apply consequences (story_page_consequences) if not loaded
		if (!$this->session->flashdata('loaded')) {
			$consequences = $this->pages_model->get_consequences_for_page($id);
			foreach ($consequences as $consequence) {
				$attribute = $consequence['attribute'];
				$value = $this->attributes_model->get_for_user($user, $attribute);
				$value = $value['value'];
				$operator = $consequence['operator'];
				$consequence_value = $consequence['value'];
				
				switch ($operator) {
					case 1: // +=
						$value += $consequence_value; break;
					case 2: // -=
						$value -= $consequence_value; break;
					case 3: // =
						$value = $consequence_value; break;
				}
				
				// Apply
				$this->attributes_model->update_for_user($user, $attribute, $value);
			}
		}
		
		 // Achievement unlocking
		$achievements = $this->achievements_model->get_all();
		foreach ($achievements as $achievement) {
			// Skip already set achievements
			if ($this->achievements_model->get_for_user($user, $achievement['id'])) {
				continue;
			}
			
			// Check comparison
			$value = $this->attributes_model->get_for_user($user, $achievement['attribute']);
			$value = $value['value'];
			$comparison = $achievement['comparison'];
			$achievement_value = $achievement['value'];
			
			$achievement_unlocked = false;
			switch ($comparison) {
				case 1 : // ==
					$achievement_unlocked = ($value == $achievement_value); break;
				case 2 : // !=
					$achievement_unlocked = ($value != $achievement_value); break;
				case 3 : // >
					$achievement_unlocked = ($value > $achievement_value); break;
				case 4 : // >=
					$achievement_unlocked = ($value >= $achievement_value); break;
				case 5 : // <
					$achievement_unlocked = ($value < $achievement_value); break;
				case 6 : // <=
					$achievement_unlocked = ($value <= $achievement_value); break;
			}
			if ($achievement_unlocked) {
				$this->achievements_model->set_for_user($user, $achievement['id']);
			}
		}
		
		// Option filtering
		$options = array();
		$options_for_page = $this->options_model->get_options_for_page($id);
		foreach ($options_for_page as $option) {
			$conditions = $this->options_model->get_conditions_for_option($option['id']);
			
			$conditions_met = true;
			foreach ($conditions as $condition) {
				// Check conditions
				$value = $this->attributes_model->get_for_user($user, $condition['attribute']);
				$value = $value['value'];
				$comparison = $condition['comparison'];
				$condition_value = $condition['value'];
			
				switch ($comparison) {
					case 1: // ==
						$conditions_met = ($value == $condition_value); break;
					case 2: // !=
						$conditions_met = ($value != $condition_value); break;
					case 3: // >
						$conditions_met = ($value > $condition_value); break;
					case 4: // >=
						$conditions_met = ($value >= $condition_value); break;
					case 5: // <
						$conditions_met = ($value < $condition_value); break;
					case 6: // <=
						$conditions_met = ($value <= $condition_value); break;
				}
				
				if (!$conditions_met) { break; }
			}
			
			if ($conditions_met) {
				$option['has_targets'] = ($this->options_model->get_amount_of_targets_for_option($option['id'], false) > 0);
				array_push($options, $option);
			}
		}
		
		//Update Options 
		$updated_options = array();
		
		foreach($options as $opt) {
			unset($icon);
			$icon = $this->assets_model->get_icon($opt['icon']);
			
			if ($icon != null) {
				$opt['icon'] = $icon[$device."_uri"];
			} else {
				//TODO: Implement Default Icon Option in Story_Settigns
				$default_icon = $this->settings_model->get_story_setting('default_icon');
				$default_icon = $this->assets_model->get_icon($default_icon['value']);
				$opt['icon'] = $default_icon[$device."_uri"];
			}
			
			array_push($updated_options, $opt);
		}
			
		$this->data['options'] = $updated_options;		

		// Set last page for user
		$this->ion_auth->update($user, array('last_page' => $id));
		
		$this->_render_page('pages/view', $this->data);
	}
	
	public function add() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('content', 'Content', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$title = $this->input->post('title');
			$description = $this->input->post('description');
			$content = $this->input->post('content');
			$page_image = $this->input->post('page_image');
			
			$id = $this->pages_model->create($title, $description, $content, $page_image);
			redirect('page/edit/'.$id);
		} else {
			//display the add page form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->data['title'] = array(
				'name'  => 'title',
				'id'    => 'title',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('title'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->input->post('description'),
			);
			$this->data['content'] = array(
				'name'  => 'content',
				'id'    => 'content',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('content'),
			);
			$this->data['page_images'] = $this->assets_model->get_page_images();

			$this->_render_page('pages/add', $this->data);
		}
	}
	
	public function edit($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('content', 'Content', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$title = $this->input->post('title');
			$description = $this->input->post('description');
			$content = $this->input->post('content');
			$page_image = $this->input->post('page_image');
			
			$this->pages_model->update($id, $title, $description, $content, $page_image);
			redirect('page/show/'.$id);
		} else {
			//display the add page form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['active_tab'] = ($this->session->flashdata('active_tab')) ? $this->session->flashdata('active_tab') : 'option';
			
			$page = $this->pages_model->get($id);
			$this->data['page'] = $page;
			$this->data['consequences'] = $this->pages_model->get_consequences_for_page($id);
			
			$this->data['title'] = array(
				'name'  => 'title',
				'id'    => 'title',
				'type'  => 'text',
				'value' => ($this->input->post('title')) ? $this->input->post('title') : $page['title'],
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => ($this->input->post('description')) ? $this->input->post('description') : $page['description'],
			);
			$this->data['content'] = array(
				'name'  => 'content',
				'id'    => 'content',
				'type'  => 'text',
				'value' => ($this->input->post('content')) ? $this->input->post('content') : $page['content'],
			);
			
			$options = array();
			foreach($this->options_model->get_options_for_page($id) as $option) {
				$option['has_targets'] = ($this->options_model->get_amount_of_targets_for_option($option['id'], false) > 0);
				array_push($options, $option);
			}
			$this->data['options'] = $options;
			$this->data['icons'] = $this->assets_model->get_icons();
			$this->data['page_images'] = $this->assets_model->get_page_images();
			$this->data['targets'] = $this->options_model->get_targets($id);
			$this->_render_page('pages/edit',$this->data);
		}
	}
	
	public function delete($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		if ($id == $this->settings_model->get_value('start_page')) { show_error('You cannot delete the current start page.'); }
		
		// Delete image on server
		$page = $this->pages_model->get($id);
		$image = $this->page_images_model->get($page['image']);
		if ($image) {
			if (file_exists('../img/desktop/'.$image['desktop_uri'])) { unlink ('../img/desktop/'.$image['desktop_uri']); }
			if (file_exists('../img/mobile/'.$image['mobile_uri'])) { unlink ('../img/mobile/'.$image['mobile_uri']); }
		}
		
		// Delete page
		$this->pages_model->delete($id);
		
		redirect('story/list_pages', 'refresh');
	}
	
	public function add_consequence($page) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('attribute', 'Attribute', 'required');
		$this->form_validation->set_rules('operator', 'Operator', 'required');
		$this->form_validation->set_rules('value', 'Value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$attribute = $this->input->post('attribute');
			$operator = $this->input->post('operator');
			$value = $this->input->post('value');
			
			$this->pages_model->create_consequence($page, $attribute, $operator, $value);
			
			$this->session->set_flashdata('tab_to_open', 'consequence');
			redirect('page/edit/'.$page);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->data['attributes'] = $this->attributes_model->get_all();
			$this->data['attribute'] = array(
				'name'  => 'attribute',
				'id'    => 'attribute',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('attribute'),
			);
			$this->data['operators'] = $this->attributes_model->get_attribute_operators();
			$this->data['operator'] = array(
				'name'  => 'operator',
				'id'    => 'operator',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('operator'),
			);
			$this->data['value'] = array(
				'name'  => 'value',
				'id'    => 'value',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('value'),
			);
			
			$this->_render_page('pages/consequences/add', $this->data);
		}
	}
	public function edit_consequence($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('attribute', 'Attribute', 'required');
		$this->form_validation->set_rules('operator', 'Operator', 'required');
		$this->form_validation->set_rules('value', 'Value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$attribute = $this->input->post('attribute');
			$operator = $this->input->post('operator');
			$value = $this->input->post('value');
			
			$this->pages_model->update_consequence($id, $attribute, $operator, $value);
			
			$helper = $this->pages_model->get_consequence($id);
			$page = $helper['page'];
			$this->session->set_flashdata('tab_to_open', 'consequence');
			redirect('page/edit/'.$page);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$consequence = $this->pages_model->get_consequence($id);
			$this->data['consequence'] = $consequence;
			
			$this->data['attributes'] = $this->attributes_model->get_all();
			$this->data['attribute'] = array(
				'name'  => 'attribute',
				'id'    => 'attribute',
				'type'  => 'text',
				'value' => ($this->input->post('attribute')) ? $this->input->post('attribute') : $consequence['attribute'],
			);
			$this->data['operators'] = $this->attributes_model->get_attribute_operators();
			$this->data['operator'] = array(
				'name'  => 'operator',
				'id'    => 'operator',
				'type'  => 'text',
				'value' => ($this->input->post('operator')) ? $this->input->post('operator') : $consequence['operator'],
			);
			$this->data['value'] = array(
				'name'  => 'value',
				'id'    => 'value',
				'type'  => 'text',
				'value' => ($this->input->post('value')) ? $this->input->post('value') : $consequence['value'],
			);
			
			$this->_render_page('pages/consequences/edit', $this->data);
		}
	}
	public function delete_consequence($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		$helper = $this->pages_model->get_consequence($id);
		$page = $helper['page'];
		
		$this->pages_model->delete_consequence($id);
		$this->session->set_flashdata('tab_to_open', 'consequence');
		redirect('page/edit/'.$page);
	}
	
	protected function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}