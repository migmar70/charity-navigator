<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Countries extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'browse';
    }

	public function index()
	{
		$this->data['activeButton'] = 'all';
		$this->data['items'] = $this->model->getCountries();
		$this->load->view('countries/index', $this->data);
	}

	public function regions()
	{
		$this->data['activeButton'] = 'regions';
		$this->data['items'] = $this->model->getCountriesByRegions();
		$this->load->view('countries/regions', $this->data);
	}

	public function country()
	{
		$slug = $this->uri->segment(2);
		$this->data['data'] = $this->model->getCountryBySlugWithOrganizations( $slug );
		$this->load->view('countries/country', $this->data);
	}


}
