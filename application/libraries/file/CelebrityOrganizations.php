<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CN_CelebrityOrganizations extends CN_FileLoader {

    public function __construct( $folder, $version ){

        $this->version = $version;
        $this->process_folder($folder);

        echo( count($this->data) . ' Celebrity Organizations parsed<br/>' );
    }

    public function newObject($object){

        $newObject = (object)array(
                'version' => (string)$this->version,
                'organization_uri' => (string)$object->orgid,
                'celebrity_uri' => (string)$object->celebrityid,
                'celebrityrelationship_uri' => (string)$object->relationshipid,
                'resource_uri' => (string)$object->resource_uri
            );

        $this->data[] = $newObject;
    }

    public function isFile($pathinfo){
        return strstr($pathinfo['filename'], 'celebrity-orgs-') == false ? false : true;
    }

    public function linkWithOrganizations( $organizations ){
        foreach ($this->data as $item) {
            $organization = $organizations->findByUri($item->organization_uri);
            if( $organization == null ){
                die("<p style='color:red;'>************* ERROR: Organization '$item->organization_uri' for Celebrity Organization '$item->resource_uri' not found!<p>");
            }
            $item->organizationid = $organization->id;
        }
    }

}
