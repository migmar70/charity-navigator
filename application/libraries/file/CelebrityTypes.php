<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CN_CelebrityTypes extends CN_FileLoader {

    public function __construct($folder,$version){

        $this->version = $version;
        $this->process_folder($folder);

        echo( count($this->data) . ' Celebrity Types parsed<br/>' );
    }

    public function newObject($object){

        $newObject = (object)array(
                'version' => (int)$this->version,
                'id' => (int)$object->typeid,
                'type' => (string)$object->type,
                'slug' => CN_Common::slugify((string)$object->type),
                'resource_uri' => (string)$object->resource_uri
            );

        echo("Celebrity Type: $newObject->type => $newObject->slug <br/>");     

        $this->data[] = $newObject;
    }

    public function isFile($pathinfo){
        return strstr($pathinfo['filename'], 'celebrity-types-') == false ? false : true;
    }

    public function findByName($name){
        foreach ($this->data as $item) {
            if( $item->type === $name ){
                return $item;
            }
        }
        return null;
    }

}
