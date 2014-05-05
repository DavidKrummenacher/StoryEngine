<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Achievement extends CI_Controller {
	
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
		$this->load->model('attributes_model');
		$this->load->model('achievements_model');
		
		$this->lang->load('storyengine');
		
		$this->dir_icons_desktop = './assets/achievements/desktop/';
		$this->dir_icons_mobile = './assets/achievements/mobile/';
		$this->icons_width_desktop = 48; // TODO: Fix width, maybe with settings
		$this->icons_width_mobile = 32; // TODO: Fix width, maybe with settings
	}
	
	public function index() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		$this->data['message'] = ($this->ion_auth->errors()) ? $this->ion_auth->errors() : $this->session->flashdata('message');
		
		$this->data['achievements'] = $this->achievements_model->get_all();
		$this->_render_page('achievements/list', $this->data);
	}
	
	public function show() {
		if (!$this->ion_auth->logged_in()) { redirect('story/login', 'refresh'); }
		
		$this->data['achievements'] = $this->achievements_model->get_all();
		$this->_render_page('achievements/show', $this->data);
	}
	
	public function add() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('attribute', 'Attribute', 'required');
		$this->form_validation->set_rules('comparison', 'Comparison', 'required');
		$this->form_validation->set_rules('value', 'Value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$attribute = $this->input->post('attribute');
			$comparison = $this->input->post('comparison');
			$value = $this->input->post('value');
			
			$filename = $this->_upload_single_file(
				$this->dir_icons_desktop,
				$this->dir_icons_mobile,
				$this->icons_width_desktop,
				$this->icons_width_mobile
			);
			$desktop_uri = $filename;
			$mobile_uri = $filename;
			
			$this->achievements_model->create($name, $description, $desktop_uri, $mobile_uri, $attribute, $comparison, $value);
			redirect('achievement');
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
			
			$this->_render_page('achievements/add', $this->data);
		}
	}
	public function edit($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('attribute', 'Attribute', 'required');
		$this->form_validation->set_rules('comparison', 'Comparison', 'required');
		$this->form_validation->set_rules('value', 'Value', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$achievement = $this->achievements_model->get($id);
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$attribute = $this->input->post('attribute');
			$comparison = $this->input->post('comparison');
			$value = $this->input->post('value');
			$desktop_uri = $achievement['desktop_uri'];
			$mobile_uri = $achievement['mobile_uri'];
			
			$filename = $this->_upload_single_file(
				$this->dir_icons_desktop,
				$this->dir_icons_mobile,
				$this->icons_width_desktop,
				$this->icons_width_mobile,
				$achievement
			);
			if ($filename != null) {
				$desktop_uri = $filename;
				$mobile_uri = $filename;
			}
			
			$this->achievements_model->update($id, $name, $description, $desktop_uri, $mobile_uri, $attribute, $comparison, $value);
			redirect('achievement');
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$achievement = $this->achievements_model->get($id);
			$this->data['achievement'] = $achievement;
			
			$this->data['name'] = array(
				'name'  => 'name',
				'id'    => 'name',
				'type'  => 'text',
				'value' => ($this->input->post('name')) ? $this->input->post('name') : $achievement['name'],
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => ($this->input->post('description')) ? $this->input->post('description') : $achievement['description'],
			);
			$this->data['attributes'] = $this->attributes_model->get_all();
			$this->data['attribute'] = array(
				'name'  => 'attribute',
				'id'    => 'attribute',
				'type'  => 'text',
				'value' => ($this->input->post('attribute')) ? $this->input->post('attribute') : $achievement['attribute'],
			);
			$this->data['comparisons'] = $this->attributes_model->get_attribute_comparisons();
			$this->data['comparison'] = array(
				'name'  => 'comparison',
				'id'    => 'comparison',
				'type'  => 'text',
				'value' => ($this->input->post('comparison')) ? $this->input->post('comparison') : $achievement['comparison'],
			);
			$this->data['value'] = array(
				'name'  => 'value',
				'id'    => 'value',
				'type'  => 'text',
				'value' => ($this->input->post('value')) ? $this->input->post('value') : $achievement['value'],
			);
			
			$this->_render_page('achievements/edit', $this->data);
		}
	}
	public function delete($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		// delete files
		$img = $this->achievements_model->get($id);
		if (file_exists($this->dir_icons_desktop.$img['desktop_uri'])) { unlink ($this->dir_icons_desktop.$img['desktop_uri']); }
		if (file_exists($this->dir_icons_mobile.$img['mobile_uri'])) { unlink ($this->dir_icons_mobile.$img['mobile_uri']); }
		
		$this->achievements_model->delete($id);
		redirect('achievement');
	}
	
	protected function _upload_single_file($dir_desktop, $dir_mobile, $desktop_width, $mobile_width, $prev = null) {
		//upload stuff
		$upconfig['upload_path'] = $dir_desktop;
		$upconfig['allowed_types'] = 'jpg|jpeg|png|gif';
		$upconfig['max_size'] = '2048';
		//$upconfig['max_height'] = "768";
		//$upconfig['max_width'] = "1024";
		$upconfig['encrypt_name'] = true;
		
		$this->load->library('upload', $upconfig);
		
		$filename = null;
		if (!isset($_FILES['userfile']) || empty($_FILES['userfile']['name'])) { return $filename; }
		
		if ($this->upload->do_upload('userfile')) {
			// get filename
			$uploaddata = $this->upload->data();
			if (!$uploaddata['is_image']) {
				$this->session->set_flashdata('message', 'File isn\'t an image. Only images can be uploaded!');
				return $filename;
			}
			$filename = $uploaddata['file_name'];
			
			// delete previous
			if ($prev != null) {
				if ($prev['desktop_uri'] && file_exists($dir_desktop.$prev['desktop_uri'])) { unlink ($dir_desktop.$prev['desktop_uri']); }
				if ($prev['mobile_uri'] && file_exists($dir_mobile.$prev['mobile_uri'])) { unlink ($dir_mobile.$prev['mobile_uri']); }
			}
			
			// copy to mobile
			copy($dir_desktop.$filename, $dir_mobile.$filename);
			
			// resize
			$this->_resize($uploaddata['image_width'], $dir_desktop.$filename, $desktop_width); // desktop image
			$this->_resize($uploaddata['image_width'], $dir_mobile.$filename, $mobile_width); // mobile image
		} else {
			$this->session->set_flashdata('message', $this->upload->display_errors());
		}
		
		return $filename;
	}
	
	protected function _resize($original_width, $image_uri, $max_width) {
		if ($original_width > $max_width) {
			$this->load->library('image_lib');
			$res_config['image_library'] = 'gd2';
			$res_config['source_image'] = $image_uri;
			$res_config['maintain_ratio'] = TRUE;
			$res_config['width'] = $max_width;
			$res_config['height'] = $max_width;
			$res_config['master_dim'] = 'width';
			$this->image_lib->initialize($res_config);
			$this->image_lib->resize();
			$this->image_lib->clear();
		}
	}
	
	protected function _render_page($view, $data = null, $render = false) {
		$this->viewdata = (empty($data)) ? $this->data: $data;
		
		$view_html = $this->load->view('templates/header', $this->viewdata);
		$view_html .= $this->load->view($view, $this->viewdata, $render);
		$view_html .= $this->load->view('templates/footer', $this->viewdata);
		
		if (!$render) return $view_html;
	}
}