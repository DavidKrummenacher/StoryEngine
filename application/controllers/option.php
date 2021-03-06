<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Option extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->helper('bootstrap_adjustments');
		$this->load->model('settings_model');
		$this->load->model('attributes_model');
		$this->load->model('pages_model');
		$this->load->model('assets_model');
		$this->load->model('options_model');
		
		$this->lang->load('storyengine');
	}
	
	public function choose($id) {
		if (!$this->ion_auth->logged_in()) { redirect('story/login', 'refresh'); }
		
		// Checks (story_option_checks)
		$success = true;
		$checks = $this->options_model->get_checks_for_option($id);
		foreach ($checks as $check) {
			// Check for failure
			$value = $this->attributes_model->get_for_user($this->ion_auth->user()->row()->id, $check['attribute']);
			$value = $value['value'];
			$comparison = $check['comparison'];
			$check_value = ($check['random'] == 0) ? $check['value'] : rand(0, $check['value']);
			
			switch ($comparison) {
				case 1: // ==
					$success = ($value == $check_value); break;
				case 2: // !=
					$success = ($value != $check_value); break;
				case 3: // >
					$success = ($value > $check_value); break;
				case 4: // >=
					$success = ($value >= $check_value); break;
				case 5: // <
					$success = ($value < $check_value); break;
				case 6: // <=
					$success = ($value <= $check_value); break;
			}
			
			if (!$success) { break; }
		}
		
		// Choose random page based on success (story_option_targets)
		$targets = $this->options_model->get_targets_for_option($id, !$success);
		$target = $targets[array_rand($targets)];
		
		// Apply consequences (story_option_consequences)
		$consequences = $this->options_model->get_consequences_for_option($id);
		foreach ($consequences as $consequence) {
			$attribute = $consequence['attribute'];
			$value = $this->attributes_model->get_for_user($this->ion_auth->user()->row()->id, $attribute);
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
			$this->attributes_model->update_for_user($this->ion_auth->user()->row()->id, $attribute, $value);
		}
		
		// Redirect to page
		redirect('page/show/'.$target['target_page']);
	}

	public function add($page) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('order', 'Order', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$order = $this->input->post('order');
			$icon = ($this->input->post('icon') == 'null') ? null : $this->input->post('icon');
			$text = $this->input->post('text');
			
			$id = $this->options_model->create($page, $order, $icon, $text);
			redirect('option/edit/'.$id);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->data['order'] = array(
				'name'  => 'order',
				'id'    => 'order',
				'type'  => 'number',
				'value' => $this->form_validation->set_value('order'),
			);
			$this->data['icons'] = $this->assets_model->get_icons();
			$this->data['icon'] = array(
				'name'  => 'icon',
				'id'    => 'icon',
				'type'  => 'text',
				'value' => $this->input->post('icon'),
			);
			$this->data['text'] = array(
				'name'  => 'text',
				'id'    => 'text',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('text'),
			);
			
			$this->_render_page('options/add', $this->data);
		}
	}
	public function edit($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('order', 'Order', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$order = $this->input->post('order');
			$icon = ($this->input->post('icon') == 'null') ? null : $this->input->post('icon');
			$text = $this->input->post('text');
			
			$this->options_model->update($id, $order, $icon, $text);
			redirect('option/edit/'.$id);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['active_tab'] = ($this->session->flashdata('active_tab')) ? $this->session->flashdata('active_tab') : 'condition';
			
			$option = $this->options_model->get($id);
			$this->data['option'] = $option;
			
			$this->data['conditions'] = $this->options_model->get_conditions_for_option($id);
			$this->data['targets'] = $this->options_model->get_targets_for_option($id);
			$this->data['checks'] = $this->options_model->get_checks_for_option($id);
			$this->data['consequences'] = $this->options_model->get_consequences_for_option($id);
			
			$this->data['order'] = array(
				'name'  => 'order',
				'id'    => 'order',
				'type'  => 'number',
				'value' => ($this->input->post('order')) ? $this->input->post('order') : $option['order'],
			);
			$this->data['icons'] = $this->assets_model->get_icons();
			$this->data['icon'] = array(
				'name'  => 'icon',
				'id'    => 'icon',
				'type'  => 'text',
				'value' => ($this->input->post('icon')) ? $this->input->post('icon') : $option['icon'],
			);
			$this->data['text'] = array(
				'name'  => 'text',
				'id'    => 'text',
				'type'  => 'text',
				'value' => ($this->input->post('text')) ? $this->input->post('text') : $option['text'],
			);
			
			$this->_render_page('options/edit', $this->data);
		}
	}
	public function delete($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		$option = $this->options_model->get($id);
		$page = $option['source_page'];
		
		$this->options_model->delete($id);
		redirect('page/edit/'.$page);
	}
	
	public function add_condition($option) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('attribute', 'Attribute', 'required');
		$this->form_validation->set_rules('comparison', 'Comparison', 'required');
		$this->form_validation->set_rules('value', 'Value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$attribute = $this->input->post('attribute');
			$comparison = $this->input->post('comparison');
			$value = $this->input->post('value');
			
			$this->options_model->create_condition($option, $attribute, $comparison, $value);
			
			$this->session->set_flashdata('active_tab', 'condition');
			redirect('option/edit/'.$option);
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
			$this->data['comparisons'] = $this->attributes_model->get_attribute_comparisons();
			$this->data['comparison'] = array(
				'name'  => 'comparison',
				'id'    => 'comparison',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('comparison'),
			);
			$this->data['value'] = array(
				'name'  => 'value',
				'id'    => 'value',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('value'),
			);
			
			$this->_render_page('options/conditions/add', $this->data);
		}
	}
	public function edit_condition($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('attribute', 'Attribute', 'required');
		$this->form_validation->set_rules('comparison', 'Comparison', 'required');
		$this->form_validation->set_rules('value', 'Value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$attribute = $this->input->post('attribute');
			$comparison = $this->input->post('comparison');
			$value = $this->input->post('value');
			
			$this->options_model->update_condition($id, $attribute, $comparison, $value);
			
			$helper = $this->options_model->get_condition($id);
			$option = $helper['option'];
			$this->session->set_flashdata('active_tab', 'condition');
			redirect('option/edit/'.$option);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$condition = $this->options_model->get_condition($id);
			$this->data['condition'] = $condition;
			
			$this->data['attributes'] = $this->attributes_model->get_all();
			$this->data['attribute'] = array(
				'name'  => 'attribute',
				'id'    => 'attribute',
				'type'  => 'text',
				'value' => ($this->input->post('attribute')) ? $this->input->post('attribute') : $condition['attribute'],
			);
			$this->data['comparisons'] = $this->attributes_model->get_attribute_comparisons();
			$this->data['comparison'] = array(
				'name'  => 'comparison',
				'id'    => 'comparison',
				'type'  => 'text',
				'value' => ($this->input->post('comparison')) ? $this->input->post('comparison') : $condition['comparison'],
			);
			$this->data['value'] = array(
				'name'  => 'value',
				'id'    => 'value',
				'type'  => 'text',
				'value' => ($this->input->post('value')) ? $this->input->post('value') : $condition['value'],
			);
			
			$this->_render_page('options/conditions/edit', $this->data);
		}
	}
	public function delete_condition($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		$helper = $this->options_model->get_condition($id);
		$option = $helper['option'];
		
		$this->options_model->delete_condition($id);
		$this->session->set_flashdata('active_tab', 'condition');
		redirect('option/edit/'.$option);
	}
	
	public function add_target($option) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('target_page', 'Target', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$target_page = $this->input->post('target_page');
			$fail = (bool) $this->input->post('fail');
			
			$this->options_model->create_target($option, $target_page, $fail);
			
			$this->session->set_flashdata('active_tab', 'target');
			redirect('option/edit/'.$option);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->data['pages'] = $this->pages_model->get_all();
			$this->data['target_page'] = array(
				'name'  => 'target_page',
				'id'    => 'target_page',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('target_page'),
			);
			$this->data['fail'] = array(
				'name'  => 'fail',
				'id'    => 'fail',
				'type'  => 'checkbox',
				'checked' => $this->form_validation->set_value('fail'),
				'value' => 'fail',
			);
			
			$this->_render_page('options/targets/add', $this->data);
		}
	}
	public function edit_target($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('target_page', 'Target', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$target_page = $this->input->post('target_page');
			$fail = (bool) $this->input->post('fail');
			
			$this->options_model->update_target($id, $target_page, $fail);
			
			$helper = $this->options_model->get_target($id);
			$option = $helper['option'];
			$this->session->set_flashdata('active_tab', 'target');
			redirect('option/edit/'.$option);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$target = $this->options_model->get_target($id);
			$this->data['target'] = $target;
			
			$this->data['pages'] = $this->pages_model->get_all();
			$this->data['target_page'] = array(
				'name'  => 'target_page',
				'id'    => 'target_page',
				'type'  => 'text',
				'value' => ($this->input->post('target_page')) ? $this->input->post('target_page') : $target['target_page'],
			);
			$this->data['fail'] = array(
				'name'  => 'fail',
				'id'    => 'fail',
				'type'  => 'checkbox',
				'checked' => ($this->input->post('fail')) ? $this->input->post('fail') : $target['fail'],
				'value' => 'fail',
			);
			
			$this->_render_page('options/targets/edit', $this->data);
		}
	}
	public function delete_target($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		$helper = $this->options_model->get_target($id);
		$option = $helper['option'];
		
		$this->options_model->delete_target($id);
		$this->session->set_flashdata('active_tab', 'target');
		redirect('option/edit/'.$option);
	}
	
	public function add_check($option) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('attribute', 'Attribute', 'required');
		$this->form_validation->set_rules('comparison', 'Comparison', 'required');
		$this->form_validation->set_rules('value', 'Value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$attribute = $this->input->post('attribute');
			$comparison = $this->input->post('comparison');
			$value = $this->input->post('value');
			$random = (bool) $this->input->post('random');
			
			$this->options_model->create_check($option, $attribute, $comparison, $value, $random);
			
			$this->session->set_flashdata('active_tab', 'check');
			redirect('option/edit/'.$option);
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
			$this->data['comparisons'] = $this->attributes_model->get_attribute_comparisons();
			$this->data['comparison'] = array(
				'name'  => 'comparison',
				'id'    => 'comparison',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('comparison'),
			);
			$this->data['value'] = array(
				'name'  => 'value',
				'id'    => 'value',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('value'),
			);
			$this->data['random'] = array(
				'name'  => 'random',
				'id'    => 'random',
				'type'  => 'checkbox',
				'checked' => $this->form_validation->set_value('random'),
				'value' => 'random',
			);
			
			$this->_render_page('options/checks/add', $this->data);
		}
	}
	public function edit_check($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('attribute', 'Attribute', 'required');
		$this->form_validation->set_rules('comparison', 'Comparison', 'required');
		$this->form_validation->set_rules('value', 'Value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$attribute = $this->input->post('attribute');
			$comparison = $this->input->post('comparison');
			$value = $this->input->post('value');
			$random = (bool) $this->input->post('random');
			
			$this->options_model->update_check($id, $attribute, $comparison, $value, $random);
			
			$helper = $this->options_model->get_check($id);
			$option = $helper['option'];
			$this->session->set_flashdata('active_tab', 'check');
			redirect('option/edit/'.$option);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$check = $this->options_model->get_check($id);
			$this->data['check'] = $check;
			
			$this->data['attributes'] = $this->attributes_model->get_all();
			$this->data['attribute'] = array(
				'name'  => 'attribute',
				'id'    => 'attribute',
				'type'  => 'text',
				'value' => ($this->input->post('attribute')) ? $this->input->post('attribute') : $check['attribute'],
			);
			$this->data['comparisons'] = $this->attributes_model->get_attribute_comparisons();
			$this->data['comparison'] = array(
				'name'  => 'comparison',
				'id'    => 'comparison',
				'type'  => 'text',
				'value' => ($this->input->post('comparison')) ? $this->input->post('comparison') : $check['comparison'],
			);
			$this->data['value'] = array(
				'name'  => 'value',
				'id'    => 'value',
				'type'  => 'text',
				'value' => ($this->input->post('value')) ? $this->input->post('value') : $check['value'],
			);
			$this->data['random'] = array(
				'name'  => 'random',
				'id'    => 'random',
				'type'  => 'checkbox',
				'checked' => ($this->input->post('random')) ? $this->input->post('random') : $check['random'],
				'value' => 'random',
			);
			
			$this->_render_page('options/checks/edit', $this->data);
		}
	}
	public function delete_check($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		$helper = $this->options_model->get_check($id);
		$option = $helper['option'];
		
		$this->options_model->delete_check($id);
		$this->session->set_flashdata('active_tab', 'check');
		redirect('option/edit/'.$option);
	}
	
	public function add_consequence($option) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('attribute', 'Attribute', 'required');
		$this->form_validation->set_rules('operator', 'Operator', 'required');
		$this->form_validation->set_rules('value', 'Value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$attribute = $this->input->post('attribute');
			$operator = $this->input->post('operator');
			$value = $this->input->post('value');
			
			$this->options_model->create_consequence($option, $attribute, $operator, $value);
			
			$this->session->set_flashdata('active_tab', 'consequence');
			redirect('option/edit/'.$option);
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
			
			$this->_render_page('options/consequences/add', $this->data);
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
			
			$this->options_model->update_consequence($id, $attribute, $operator, $value);
			
			$helper = $this->options_model->get_consequence($id);
			$option = $helper['option'];
			$this->session->set_flashdata('active_tab', 'consequence');
			redirect('option/edit/'.$option);
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$consequence = $this->options_model->get_consequence($id);
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
			
			$this->_render_page('options/consequences/edit', $this->data);
		}
	}
	public function delete_consequence($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		$helper = $this->options_model->get_consequence($id);
		$option = $helper['option'];
		
		$this->options_model->delete_consequence($id);
		$this->session->set_flashdata('active_tab', 'consequence');
		redirect('option/edit/'.$option);
	}
	
	protected function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}