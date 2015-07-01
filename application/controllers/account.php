<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/controller.php'); 

class Account extends CN_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
        $this->data['navbar'] = '';
    }

    public function login()
    {
        $this->load->view('account/login',$this->data);
    }


    public function testauthenticate(){

        $this->load->library('encrypt');

        $this->_authenticate( 'miguel@miguelmatinez.com', 'password' );
    }

    public function authenticate(){

        $this->load->library('encrypt');

        $this->_authenticate( trim($this->input->post('email')), $this->input->post('password') );
    }

    public function register(){

        $this->load->view('account/register',$this->data);
    }

    public function signup(){

    }

    private function _authenticate($email, $password) {

        $user = $this->model->getUserByEmail($email);
        
        if( $user == null ){
            $this->toJsonResponse( $this->buildResponseFail('user is null - '.$email) );
            return;
        }
            

        if( $user !== null && $this->encrypt->decode($user->password) === $password ){
            unset($user->password);

            $user->{'orgs'} = $this->model->getOrganizationsByUserId( $user->id );

            $response = $this->buildResponseWithData(true,$user);

            $_SESSION['username'] = $email;
        } 
        else {
            $response = $this->buildResponseFail('Invalid username or password.' );
        }

        $this->toJsonResponse( $response );
    }
}
