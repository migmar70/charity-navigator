<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/controller.php'); 

class Home extends CN_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
    }

	public function index()
	{
		$this->data['toptenlists'] = $this->model->getTopTens();
		$this->data['hottopics'] = $this->model->getHotTopics();
		$this->data['tips'] = $this->model->getTips();
		$this->data['authenticatedCls'] =  isset($_SESSION['username'])? 'authenticated' : '';
		$this->load->view('home/index', $this->data);
	}
}
