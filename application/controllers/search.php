<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'search';
    }

    public function index()
    {
        $this->data['items'] = $this->model->getOrganizations();
        $this->load->view('search/index',$this->data);
    }
}
