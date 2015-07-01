<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/controller.php'); 

class Api2 extends CN_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('CharityNavigatorModel', 'model');
        $this->model->getVersion();
    }

    //
    // http://php.charitynavigator.local/api2/organizations
    //
    public function organizations(){
        $this->toJsonResponse( 
            $this->buildResponseWithData( 
                true, 
                $this->model->getOrganizations()
            )
        );
    }

    //
    // http://php.charitynavigator.local/api2/toptenlist/10-charities-worth-watching
    //
    public function toptenlist( $slug ){
        $this->toJsonResponse( 
            $this->buildResponseWithData( 
                true, 
                $this->model->getListWithOrgs($slug)
            )
        );
    }

    //
    // http://php.charitynavigator.local/api2/organization/national-council-on-us-arab-relations
    //
    public function organization( $slug ){
        $this->toJsonResponse( 
            $this->buildResponseWithData( 
                true, 
                $this->model->getOrganizationBySlug($slug)
            )
        );
    }

    //
    // http://php.charitynavigator.local/api2/hottopic/
    //
    public function hottopic( $slug ){
        $this->toJsonResponse( 
            $this->buildResponseWithData( 
                true, 
                $this->model->getHotTopicBySlug($slug)
            )
        );
    }

    //
    // http://php.charitynavigator.local/api2/tip/be-proactive-in-your-giving
    //
    public function tip( $slug ){
        $this->toJsonResponse( 
            $this->buildResponseWithData( 
                true, 
                $this->model->getTipBySlug($slug)
            )
        );
    }

    //
    // http://php.charitynavigator.local/api2/testauthenticate
    //
    public function testauthenticate(){
        $this->_authenticate( 'migmar70@gmail.com', 'Martinez' );
    }

    //
    // http://php.charitynavigator.local/api2/authenticate
    //
    public function authenticate(){
        $this->_authenticate( trim($this->input->post('email')), $this->input->post('password') );
    }

    private function _authenticate($email, $password) {

        $user = $this->model->authenticate($email,$password);
        
        if( $user == null ){
            $this->toJsonResponse( $this->buildResponseFail('Invalid username or password: '.$email) );
            return;
        }

        $user->{'orgs'} = $this->model->getOrganizationsByUserId( $user->id );

        $response = $this->buildResponseWithData(true,$user);

        //
        // the prescense of this session variable indicates the user has been authenticated
        //
        $_SESSION['username'] = $email; 

        $this->toJsonResponse( $response );
    }

    public function logout(){
        unset($_SESSION['username']); 
    }

    public function testregister(){
        $this->_register( 'Miguel', 'migmar70@gmail.com', 'Martinez' );
    }

    public function register(){
        $this->_register( trim($this->input->post('name')), trim($this->input->post('email')), $this->input->post('password') );
    }

    private function _register($name, $email, $password){
        
        $form = new CN_RegistrationForm();

        $success = $form->validate( array('name'=>$name, 'email'=>$email, 'password'=>$password ) );
        if( $success == false ){
            $this->toJsonResponse( $this->buildResponseWithViolations($form->violations) );
            return;
        }

        if( $this->model->emailExists($email) ){
            $this->toJsonResponse( $this->buildResponseWithViolation('email','Email "'.$email.'" has already been registered.') );   
            return;
        }

        $this->model->register($name,$email,$password);

        $this->toJsonResponse( 
            $this->buildResponseWithData( 
                true, 
                $this->model->authenticate($email,$password)
            )
        );
    }

}
