<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Celebrities extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'browse';
    }

	public function index()
	{
		$this->data['activeButton'] = 'all';
		$this->data['items'] = $this->model->getCelebrities();
		$this->load->view('celebrities/index', $this->data);
	}

	public function types()
	{
		$this->data['activeButton'] = 'types';
		$this->data['items'] = $this->model->getCelebritiesByTypes();
		$this->load->view('celebrities/types', $this->data);
	}

	public function relationships()
	{
		$this->data['activeButton'] = 'relationships';
		$this->data['items'] = $this->model->getCelebritiesByRelationships();
		$this->load->view('celebrities/relationships', $this->data);
	}

	public function celebrity()
	{
		$slug = $this->uri->segment(2);
		$this->data['data'] = $this->model->getCelebrityBySlugWithOrganizations( $slug );
		$this->load->view('celebrities/celebrity', $this->data);
	}


}
