<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CN_Countries extends CN_FileLoader {

    public function __construct($folder,$version){

        $this->version = $version;
        $this->process_folder($folder);

        echo( count($this->data) . ' Countries parsed<br/>' );
    }

    public function newObject($object){

        $newObject = (object)array(
                'version' => (int)$this->version,
                'id' => (int)$object->countryid,
                'country' => (string)$object->country,
                'slug' => CN_Common::slugify((string)$object->country),
                'charity_count' => (int)$object->charity_count,
                'resource_uri' => (string)$object->resource_uri,
                'region_uri' => (string)$object->regionid
            );

        echo("Country: $newObject->country => $newObject->slug <br/>");     

        $this->data[] = $newObject;
    }

    public function isFile($pathinfo){
        return strstr($pathinfo['filename'], 'countries-') == false ? false : true;
    }

    public function linkWithRegions( $regions ){
        foreach ($this->data as $item) {
            $region = $regions->findByUri($item->region_uri);
            if( $region == null ){
                die("<p style='color:red;'>************* ERROR: region '$item->region_uri' for country '$item->country' not found!<p>");
            }
            $item->region = $region->region;
            $item->regionid = $region->id;
        }
    }

}
