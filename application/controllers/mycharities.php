<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/controller.php'); 

class Mycharities extends CN_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = 'mycharities';
    }

    public function index()
    {
        $this->data['items'] = $this->model->getMyCharities();
        $this->load->view('mycharities/index',$this->data);
    }

    public function add(){

      if ( !isset($_SESSION['username']) ) {
        return $this->buildResponse(false, array());
      }

    }
}
