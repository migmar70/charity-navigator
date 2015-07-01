<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organizations extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'featured';
    }

	public function index()
	{
		$slug = $this->uri->segment(2);
		$this->data['data'] = $this->model->getOrganizationBySlug($slug);
		$this->load->view('organizations/index', $this->data);
	}
}
