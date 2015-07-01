<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
    }

    public function index()
    {
	    header("Expires: Mon, 15 Jun 1970 07:00:00 GMT"); 
	    header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
	    header("Cache-Control: no-cache, must-revalidate"); 
	    header("Pragma: no-cache");
	    header("Content-type: application/json");

    	echo json_encode( $this->model->getOrganizations() );
    }

    public function toptenlist( $slug ){

    }
}
