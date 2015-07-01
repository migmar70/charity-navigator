<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CN_Categories extends CN_FileLoader {

    public function __construct($folder,$version){

        $this->version = $version;
        $this->process_folder($folder);

        echo( count($this->data) . ' Categories parsed<br/>' );
    }

    public function newObject($object){

        $newObject = (object)array(
                'version' => (int)$this->version,
                'id' => (int)$object->categoryid,
                'category' => (string)$object->category,
                'slug' => CN_Common::slugify((string)$object->category),
                'description' => (string)$object->description,
                'resource_uri' => (string)$object->resource_uri       
            );

        echo("Category: $newObject->category => $newObject->slug <br/>");     

        $this->data[] = $newObject;
    }

    public function isFile($pathinfo){
        return strstr($pathinfo['filename'], 'categories-') == false ? false : true;
    }

    public function findByName($name){
        foreach ($this->data as $item) {
            if( $item->category === $name ){
                return $item;
            }
        }
        return null;
    }
}

