<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Methodology extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'featured';
    }

	public function index()
	{
		$this->data['items'] = $this->model->getMethodology();
		$this->load->view('methodology/index', $this->data);
	}

	public function method()
	{
		$slug = $this->uri->segment(2);
		$this->data['data'] = $this->model->getMethodologyBySlug( $slug );
		$this->load->view('methodology/method', $this->data);
	}
}
