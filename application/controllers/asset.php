<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset extends MY_Controller {
	
	protected $dir_page_images_desktop;
	protected $dir_page_images_mobile;
	protected $page_images_width_desktop;
	protected $page_images_width_mobile;
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
		$this->load->model('assets_model');
		
		$this->lang->load('storyengine');
		
		$this->dir_page_images_desktop = './assets/page_images/desktop/';
		$this->dir_page_images_mobile = './assets/page_images/mobile/';
		$this->page_images_width_desktop = 1170; // TODO: Fix width, maybe with settings
		$this->page_images_width_mobile = 724; // TODO: Fix width, maybe with settings
		
		$this->dir_icons_desktop = './assets/icons/desktop/';
		$this->dir_icons_mobile = './assets/icons/mobile/';
		$this->icons_width_desktop = 48; // TODO: Fix width, maybe with settings
		$this->icons_width_mobile = 32; // TODO: Fix width, maybe with settings
	}
	
	public function index() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		$this->data['message'] = ($this->ion_auth->errors()) ? $this->ion_auth->errors() : $this->session->flashdata('message');
		
		$this->data['page_images'] = $this->assets_model->get_page_images();
		$this->data['icons'] = $this->assets_model->get_icons();
		$this->_render_page('assets/list', $this->data);
	}
	
	public function add_page_image() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('name', 'Name', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			
			$filename = $this->_upload_single_file(
				$this->dir_page_images_desktop,
				$this->dir_page_images_mobile,
				$this->page_images_width_desktop,
				$this->page_images_width_mobile
			);
			$desktop_uri = $filename;
			$mobile_uri = $filename;
			
			$this->assets_model->create_page_image($name, $description, $desktop_uri, $mobile_uri);
			redirect('asset');
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
			
			$this->_render_page('assets/images/add', $this->data);
		}
	}
	public function batch_upload_page_images() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		if (isset($_POST) && !empty($_POST)) {
			$files = $this->_upload_multiple_files(
				$this->dir_page_images_desktop,
				$this->dir_page_images_mobile,
				$this->page_images_width_desktop,
				$this->page_images_width_mobile
			);
			
			foreach ($files as $file) {
				$this->assets_model->create_page_image($file['name'], $file['description'], $file['desktop_uri'], $file['mobile_uri']);
			}
			redirect('asset');
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'));
			
			$this->_render_page('assets/images/batch', $this->data);
		}
	}
	public function edit_page_image($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('name', 'Name', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$image = $this->assets_model->get_page_image($id);
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$desktop_uri = $image['desktop_uri'];
			$mobile_uri = $image['mobile_uri'];
			
			$filename = $this->_upload_single_file(
				$this->dir_page_images_desktop,
				$this->dir_page_images_mobile,
				$this->page_images_width_desktop,
				$this->page_images_width_mobile,
				$image
			);
			if ($filename != null) {
				$desktop_uri = $filename;
				$mobile_uri = $filename;
			}
			
			$this->assets_model->update_page_image($id, $name, $description, $desktop_uri, $mobile_uri);
			redirect('asset');
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$image = $this->assets_model->get_page_image($id);
			$this->data['image'] = $image;
			
			$this->data['name'] = array(
				'name'  => 'name',
				'id'    => 'name',
				'type'  => 'text',
				'value' => ($this->input->post('name')) ? $this->input->post('name') : $image['name'],
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => ($this->input->post('description')) ? $this->input->post('description') : $image['description'],
			);
			
			$this->_render_page('assets/images/edit', $this->data);
		}
	}
	public function delete_page_image($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		// delete files
		$img = $this->assets_model->get_page_image($id);
		if (file_exists($this->dir_page_images_desktop.$img['desktop_uri'])) { unlink ($this->dir_page_images_desktop.$img['desktop_uri']); }
		if (file_exists($this->dir_page_images_mobile.$img['mobile_uri'])) { unlink ($this->dir_page_images_mobile.$img['mobile_uri']); }
		
		$this->assets_model->delete_page_image($id);
		redirect('asset');
	}
	
	public function add_icon() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('name', 'Name', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			
			$filename = $this->_upload_single_file(
				$this->dir_icons_desktop,
				$this->dir_icons_mobile,
				$this->icons_width_desktop,
				$this->icons_width_mobile
			);
			$desktop_uri = $filename;
			$mobile_uri = $filename;
			
			$this->assets_model->create_icon($name, $description, $desktop_uri, $mobile_uri);
			redirect('asset');
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
			
			$this->_render_page('assets/icons/add', $this->data);
		}
	}
	public function batch_upload_icons() {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		if (isset($_POST) && !empty($_POST)) {
			$files = $this->_upload_multiple_files(
				$this->dir_icons_desktop,
				$this->dir_icons_mobile,
				$this->icons_width_desktop,
				$this->icons_width_mobile
			);
			
			foreach ($files as $file) {
				$this->assets_model->create_icon($file['name'], $file['description'], $file['desktop_uri'], $file['mobile_uri']);
			}
			redirect('asset');
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'));
			
			$this->_render_page('assets/icons/batch', $this->data);
		}
	}
	public function edit_icon($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		//validate form input
		$this->form_validation->set_rules('name', 'Name', 'required');
		
		if (isset($_POST) && !empty($_POST) && $this->form_validation->run() == true) {
			$icon = $this->assets_model->get_icon($id);
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$desktop_uri = $icon['desktop_uri'];
			$mobile_uri = $icon['mobile_uri'];
			
			$filename = $this->_upload_single_file(
				$this->dir_icons_desktop,
				$this->dir_icons_mobile,
				$this->icons_width_desktop,
				$this->icons_width_mobile,
				$icon
			);
			if ($filename != null) {
				$desktop_uri = $filename;
				$mobile_uri = $filename;
			}
			
			$this->assets_model->update_icon($id, $name, $description, $desktop_uri, $mobile_uri);
			redirect('asset');
		} else {
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$icon = $this->assets_model->get_icon($id);
			$this->data['icon'] = $icon;
			
			$this->data['name'] = array(
				'name'  => 'name',
				'id'    => 'name',
				'type'  => 'text',
				'value' => ($this->input->post('name')) ? $this->input->post('name') : $icon['name'],
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => ($this->input->post('description')) ? $this->input->post('description') : $icon['description'],
			);
			
			$this->_render_page('assets/icons/edit', $this->data);
		}
	}
	public function delete_icon($id) {
		if (!$this->ion_auth->is_author()) { redirect('admin/login', 'refresh'); }
		
		// delete files
		$icon = $this->assets_model->get_icon($id);
		if (file_exists($this->dir_icons_desktop.$icon['desktop_uri'])) { unlink ($this->dir_icons_desktop.$icon['desktop_uri']); }
		if (file_exists($this->dir_icons_mobile.$icon['mobile_uri'])) { unlink ($this->dir_icons_mobile.$icon['mobile_uri']); }
		
		$this->assets_model->delete_icon($id);
		redirect('asset');
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
	
	protected function _upload_multiple_files($dir_desktop, $dir_mobile, $desktop_width, $mobile_width) {
		//upload stuff
		$upconfig['upload_path'] = $dir_desktop;
		$upconfig['allowed_types'] = 'jpg|jpeg|png|gif';
		$upconfig['max_size'] = '2048';
		//$upconfig['max_height'] = "768";
		//$upconfig['max_width'] = "1024";
		$upconfig['encrypt_name'] = true;
		
		$this->load->library('upload', $upconfig);
		
		$files = array();
		if (!isset($_FILES['userfiles']) || empty($_FILES['userfiles']['name'])) { return $files; }
		
		if ($this->upload->do_multi_upload('userfiles')) {
			$this->load->library('image_lib');
			
			// get files
			$uploaddatas = $this->upload->get_multi_upload_data();
			foreach ($uploaddatas as $uploaddata) {
				if (!$uploaddata['is_image']) {
					$this->session->set_flashdata('message', 'File \''.$uploaddata['orig_name'].'\' isn\'t an image. Only images can be uploaded! Batch aborted!');
					return $files;
				}
				$filename = $uploaddata['file_name'];
				
				// copy to mobile
				copy($dir_desktop.$filename, $dir_mobile.$filename);
				
				// resize
				$this->_resize($uploaddata['image_width'], $dir_desktop.$filename, $desktop_width); // desktop image
				$this->_resize($uploaddata['image_width'], $dir_mobile.$filename, $mobile_width); // mobile image
				
				// Add file data for storing
				$file = array(
					'name' => $uploaddata['orig_name'],
					'description' => null,
					'mobile_uri' => $filename,
					'desktop_uri' => $filename,
				);
				array_push($files, $file);
			}
		} else {
			$this->session->set_flashdata('message', $this->upload->display_errors());
		}
		
		return $files;
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