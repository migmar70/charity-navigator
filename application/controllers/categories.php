<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'browse';
    }

	public function index()
	{
		$this->data['items'] = $this->model->getCategories();
		$this->load->view('categories/index', $this->data);
	}

	public function category()
	{
		$slug = $this->uri->segment(2);
		$this->data['data'] = $this->model->getCategoryBySlugWithOrganizations( $slug );
		$this->load->view('categories/category', $this->data);
	}


}
