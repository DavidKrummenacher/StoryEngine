<?php if (!defined("BASEPATH")) { exit("No direct script access allowed"); }

class MY_Controller extends CI_Controller {
	function __construct() {
        parent::__construct();
		
		$this->load->model('display_model');
		$this->data['story_title'] = $this->display_model->get_value('story_title');
    }
}