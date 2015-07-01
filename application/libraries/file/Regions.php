<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CN_Regions extends CN_FileLoader {

    public function __construct($folder,$version){

        $this->version = $version;
        $this->process_folder($folder);

        echo( count($this->data) . ' Regions parsed<br/>' );
    }

    public function newObject($object){

        $newObject = (object)array(
                'version' => (int)$this->version,
                'id' => (int)$object->regionid,
                'region' => (string)$object->region,
                'slug' => CN_Common::slugify((string)$object->region),
                'charity_count' => (int)$object->charity_count,
                'resource_uri' => (string)$object->resource_uri
            );

        echo("Region: $newObject->region => $newObject->slug <br/>");     

        $this->data[] = $newObject;
    }

    public function isFile($pathinfo){
        return strstr($pathinfo['filename'], 'regions-') == false ? false : true;
    }

    public function findByUri( $resource_uri ){
        foreach ($this->data as $item) {
            if( $item->resource_uri === $resource_uri ){
                return $item;
            }
        }
        return null;
    }

}
