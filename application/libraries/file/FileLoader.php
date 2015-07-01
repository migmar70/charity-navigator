<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class CN_FileLoader {

    var $data = array();
    var $version = 1;

    public function process_folder($path){
        if( is_dir($path) ){
            echo "process_folder $path<br/>";
            $dir = opendir($path);
            if( $dir ){
                while( ($filename = readdir($dir)) !== false ){
                    $filespec = $path.$filename;
                    $filetype = filetype($filespec);
                    if( $filetype === 'file' ){
                        $this->process_file($filespec);
                    }
                }
                closedir($dir);
            }
        }
    }

    public function process_file($filespec){
        $pathinfo = pathinfo($filespec);
        if(strtolower($pathinfo['extension']) === 'xml'){
            if( $this->isFile($pathinfo) ){
                $this->process_file_xml($filespec);    
            }
        }
    }

    public function process_file_xml($filespec){
        echo "process_file_xml $filespec<br/>";
        if( file_exists($filespec) ){
            $response = simplexml_load_file($filespec);
            foreach ($response->objects->object as $object) {
                $this->newObject($object);
            }
        }
    }

    public function newObject($object){
    }

    public function isFile($pathinfo){
    }
}
