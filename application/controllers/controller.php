<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', '1');

class CN_Field {
    
    var $violations = array();
    var $validationRules = array();

    public function __construct($label,$name,$validationRules){
        $this->label = $label;
        $this->name = $name;
        $this->validationRules = $validationRules;
    }

    public function validate( $value ){
        
        //echo 'validating '.$this->name.'...<br/>';

        foreach ($this->validationRules as $ruleName => $ruleValue) {

            if( $ruleName === 'required' ){
                if( strlen($value) === 0 && $ruleValue == true ){
                    $this->violations[] = '"'.$this->label.'" is required.';
                }
            }
            else if( $ruleName === 'minLen' ){
                if( strlen($value) < $ruleValue ){
                    $this->violations[] = '"'.$this->label.'" must be at least '.$ruleValue.' characters long.';
                }
            }
            else if( $ruleName === 'maxLen' ){
                if( strlen($value) > $ruleValue ){
                    $this->violations[] = '"'.$this->label.'" cannot contain more than '.$ruleValue.' characters.';
                }
            } 
            else if( $ruleName === 'format' ){
                if( $ruleValue === 'email' ){
                    if( CN_Field::validEmail($value) === false ){
                        $this->violations[] = '"'.$this->label.'" is not a valid email address.';
                    }
                }
            }
        }
        return $this->violations;
    }

    /**
    Validate an email address.
    Provide email address (raw input)
    Returns true if the email address has the email 
    address format and the domain exists.
    http://www.linuxjournal.com/article/9585
    */
    static public function validEmail($email)
    {
       $isValid = true;
       $atIndex = strrpos($email, "@");

       if (is_bool($atIndex) && !$atIndex) {
          $isValid = false;
       }
       else {

          $domain = substr($email, $atIndex+1);
          $local = substr($email, 0, $atIndex);
          $localLen = strlen($local);
          $domainLen = strlen($domain);
          if ($localLen < 1 || $localLen > 64) {
             // local part length exceeded
             $isValid = false;
          }
          else if ($domainLen < 1 || $domainLen > 255) {
             // domain part length exceeded
             $isValid = false;
          }
          else if ($local[0] == '.' || $local[$localLen-1] == '.') {
             // local part starts or ends with '.'
             $isValid = false;
          }
          else if (preg_match('/\\.\\./', $local)) {
             // local part has two consecutive dots
             $isValid = false;
          }
          else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
             // character not valid in domain part
             $isValid = false;
          }
          else if (preg_match('/\\.\\./', $domain)) {
             // domain part has two consecutive dots
             $isValid = false;
          }
          else if( !preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
             // character not valid in local part unless 
             // local part is quoted
             if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
                $isValid = false;
             }
          }
          if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
             // domain not found in DNS
             $isValid = false;
          }
       }
       return $isValid;    
    }
}

class CN_Form {

    var $violations = array();
    var $fields = array();

    public function __construct(){    
    }

    public function addField($label, $name, $validationRules){
        $this->fields[$name] = new CN_Field($label,$name,$validationRules);
    }

    public function validate( $values ){
        foreach ($values as $key => $value) {
            if( isset($this->fields[$key]) ){
                $violations = $this->fields[$key]->validate($value);
                if( count($violations) > 0 ){
                    $this->violations[] = array( 'field' => $key, 'violations' => $violations );
                }
            }
        }
        //echo 'violations '.count($this->violations).'<br/';
        return count($this->violations) === 0;
    }
}

class CN_RegistrationForm extends CN_Form {

    public function __construct(){    
        $this->addField(
            'Name', 
            'name', 
            array( 
                'required' => true, 
                'minLen' => 2, 
                'maxLen'=>64
            )
        );

        $this->addField(
            'Email', 
            'email', 
            array( 
                'required' => true, 
                'maxLen'=>64, 
                'format'=>'email'
            )
        );

        $this->addField(
            'Password', 
            'password', 
            array( 
                'required' => true, 
                'minLen' => 6, 
                'maxLen' => 64
            )
        );
    }
}

class CN_LoginForm extends CN_Form {

    public function __construct(){    

        $this->addField(
            'Email', 
            'email', 
            array( 
                'required' => true, 
                'maxLen'=>64, 
                format=>''
            )
        );

        $this->addField(
            'Password', 
            'password', 
            array( 
                'required' => true, 
                'maxLen' => 64
            )
        );
    }
}


class CN_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        session_start();
    }

    protected function toJsonResponse( $response ){

        header("Expires: Mon, 15 Jun 1970 07:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");

        echo json_encode( $response );
    }

    protected function buildResponse( $success, $message, $errors, $violations, $data ){
        return (object)array(
            'success'=>$success,
            'message'=>$message,
            'errors'=>$errors, 
            'violations'=>$violations,
            'data'=> $data );
    }

    protected function buildResponseFail( $message ){
        return $this->buildResponse(false, $message, null, null, null);
    }

    protected function buildResponseSuccess(){
        return $this->buildResponse(true, '', null, null, null);
    }

    protected function buildResponseWithData( $success, $data ){
        return $this->buildResponse($success, '', null, null, $data);
    }

    protected function buildResponseWithViolations( $violations ){
        return $this->buildResponse(false, '', null, $violations, null);
    }

    protected function buildResponseWithViolation( $field, $violation ){
        return $this->buildResponse(false, '', null, array( array('field'=>$field, 'violations'=>array($violation) ) ), null);
    }
}
