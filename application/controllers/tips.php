<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tips extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'featured';
    }

	public function index()
	{
		$this->data['items'] = $this->model->getTips();
		$this->load->view('tips/index', $this->data);
	}

	public function tip()
	{
		$slug = $this->uri->segment(2);
		$this->data['data'] = $this->model->getTipsBySlug( $slug );
		$this->load->view('tips/tip', $this->data);
	}
}
