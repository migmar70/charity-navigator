<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CN_Celebrities extends CN_FileLoader {

    public function __construct($folder,$version){

        $this->version = $version;
        $this->process_folder($folder);

        echo( count($this->data) . ' Celebrities parsed<br/>' );
    }

    public function newObject($object){

        $name = (string)$object->fname . ' ' . (string)$object->mname . ' ' . (string)$object->lname;

        $newObject = (object)array(
                'version' => (int)$this->version,
                'id' => (int)$object->celebrityid,
                'name' => $name,
                'slug' => CN_Common::slugify($name),
                'resource_uri' => (string)$object->resource_uri,
                'fname' => (string)$object->fname,
                'mname' => (string)$object->mname,
                'lname' => (string)$object->lname,
                'celebritytype' => (string)$object->type

            );

        echo("Celebrity: $newObject->name => $newObject->slug <br/>");     

        $this->data[] = $newObject;
    }

    public function isFile($pathinfo){
        return strstr($pathinfo['filename'], 'celebrities-') == false ? false : true;
    }

    public function linkWithTypes( $celebrityTypes ){
        foreach ($this->data as $item) {
            $celebrityType = $celebrityTypes->findByName($item->celebritytype);
            if( $celebrityType == null ){
                die("<p style='color:red;'>************* ERROR: Celebrity Type '$item->celebritytype' for Celebrity '$item->name' not found!<p>");
            }
            $item->celebritytypeid = $celebrityType->id;

        }
    }

}
