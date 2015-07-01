<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CharityNavigatorXmlFileReader
{
    var $saveCallback;

    public function read( $path, $saveCallback ){
        $this->saveCallback = $saveCallback;
        $this->process_folder( $path );
    }

    public function process_folder($path){
        if( is_dir($path) ){
            echo "opening $path<br/>";
            $dir = opendir($path);
            if( $dir ){
                echo "reading $path<br/>";
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
            $this->process_file_xml($filespec);
        }
    }

    public function process_file_xml($filespec){
        echo "$filespec<br/>";
        if( file_exists($filespec) ){
            $response = simplexml_load_file($filespec);
            foreach ($response->objects->object as $object) {
                $this->save($object);
            }
        }
    }

    public function save( $dto ){
        $this->saveCallback['target']->{$this->saveCallback['method']}($dto);
    }
}

/* End of file CharityNavigatorXmlFileReader.php */