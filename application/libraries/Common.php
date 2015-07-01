<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CN_Common {

    static public function slugify($phrase) {
        // http://www.intrepidstudios.com/blog/2009/2/10/function-to-generate-a-url-friendly-string.aspx
        $result = strtolower($phrase);
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = trim(preg_replace("/[\s-]+/", " ", $result));
        $result = trim(substr($result, 0, 100));
        $result = preg_replace("/\s/", "-", $result);
        return $result;
    }

    static public function namefy( $fname, $mname, $lname ){
    	$name = $fname;
    	$mname2 = trim($mname);
    	if( strlen($mname2) > 0 ){
    		$name .= ' '.$mname2;
    	}
    	$lname2 = trim($lname);
    	if( strlen($lname2) > 0 ){
    		$name .= ' '.$lname2;
    	}
    	return $name;
    }

    static public function extractIdFromUri( $uri ){
        $arr = explode('/', $uri);
        return $arr[ count($arr)-2 ];
    }
}
