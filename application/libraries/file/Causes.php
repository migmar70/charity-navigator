<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CN_Causes extends CN_FileLoader {

    public function __construct($folder,$version){

        $this->version = $version;
        $this->process_folder($folder);

        echo( count($this->data) . ' Causes parsed<br/>' );
    }

    public function newObject($object){

        $newObject = (object)array(
                'version' => (int)$this->version,
                'id' => (int)$object->causeid,
                'cause' => (string)$object->cause,
                'slug' => CN_Common::slugify((string)$object->cause),
                'description' => (string)$object->description,
                'resource_uri' => (string)$object->resource_uri,
                'category' => (string)$object->category,
                'categoryid' => 0
            );

        echo("Cause: $newObject->cause => $newObject->slug <br/>");     

        $this->data[] = $newObject;
    }

    public function isFile($pathinfo){
        return strstr($pathinfo['filename'], 'causes-') == false ? false : true;
    }

    public function linkWithCategories( $categories ){
        foreach ($this->data as $cause) {
            $cause->categoryid = $categories->findByName($cause->category)->id;
        }
    }

    public function findByName($name){
        foreach ($this->data as $item) {
            if( $item->cause === $name ){
                return $item;
            }
        }
        return null;
    }

}
