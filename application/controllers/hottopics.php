<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hottopics extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'featured';
    }

	public function index()
	{
		$this->data['items'] = $this->model->getHotTopics();
		$this->load->view('hottopics/index', $this->data);
	}

	public function hottopic()
	{
		$slug = $this->uri->segment(2);
		$this->data['data'] = $this->model->getHotTopicBySlug( $slug );
		$this->load->view('hottopics/hottopic', $this->data);
	}


}
