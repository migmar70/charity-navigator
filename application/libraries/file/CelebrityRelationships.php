<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CN_CelebrityRelationships extends CN_FileLoader {

    public function __construct($folder,$version){

        $this->version = $version;
        $this->process_folder($folder);

        echo( count($this->data) . ' Celebrity Relationships parsed<br/>' );
    }

    public function newObject($object){

        $newObject = (object)array(
                'version' => (int)$this->version,
                'id' => (int)$object->relationshipid,
                'relationship' => (string)$object->relationship,
                'slug' => CN_Common::slugify((string)$object->relationship),
                'resource_uri' => (string)$object->resource_uri
            );

        echo("Celebrity Relationship: $newObject->relationship => $newObject->slug <br/>");     

        $this->data[] = $newObject;
    }

    public function isFile($pathinfo){
        return strstr($pathinfo['filename'], 'celebrity-relationships-') == false ? false : true;
    }

}
