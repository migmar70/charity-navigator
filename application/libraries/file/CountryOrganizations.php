<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CN_CountryOrganizations extends CN_FileLoader {

    public function __construct( $folder, $version ){

        $this->version = $version;
        $this->process_folder($folder);

        echo( count($this->data) . ' Country Organizations parsed<br/>' );
    }

    public function newObject($object){

        $newObject = (object)array(
                'version' => (string)$this->version,
                'organization_uri' => (string)$object->orgid,
                'country_uri' => (string)$object->countryid,
                'resource_uri' => (string)$object->resource_uri
            );

        $this->data[] = $newObject;
    }

    public function isFile($pathinfo){
        return strstr($pathinfo['filename'], 'country-orgs-') == false ? false : true;
    }

}
