<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Toptenlists extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'featured';
    }

	public function index()
	{
		$this->data['items'] = $this->model->getTopTens();
		$this->load->view('toptenlists/index', $this->data);
	}

	public function toptenlist()
	{
		$slug = $this->uri->segment(2);
		$this->data['list'] = $this->model->getListWithOrgs( $slug );
		$this->load->view('toptenlists/toptenlist', $this->data);
	}
}
