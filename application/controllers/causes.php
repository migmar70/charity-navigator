<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Causes extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'browse';
    }

	public function index()
	{
		$this->data['items'] = $this->model->getCauses();
		$this->load->view('causes/index', $this->data);
	}

	public function cause()
	{
		$slug = $this->uri->segment(2);
		$this->data['data'] = $this->model->getCauseBySlugWithOrganizations( $slug );
		$this->load->view('causes/cause', $this->data);
	}


}
