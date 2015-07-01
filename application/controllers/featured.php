<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Featured extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->data['navbar'] = 'featured';
    }

	public function index()
	{
		$this->load->view('featured/index', $this->data);
	}
}
