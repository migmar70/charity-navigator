<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require_once(FCPATH.APPPATH.'libraries/WebProvider.php'); 

class Data extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('DataModel', 'model');

        $provider = new CN_WebProvider( $this->config->item('app_id'), $this->config->item('app_key'), 3 );
        $provider->load( $this->model );

        echo 'Get some coffee!';
    }

    public function version(){
        $this->load->model('CharityNavigatorModel', 'cnModel');  
        echo $this->cnModel->getVersion().'<br/>';
        echo $this->cnModel->version.'<br/>';
    }
}

