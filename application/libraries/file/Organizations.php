<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CN_Organizations extends CN_FileLoader {

    var $largest_slug = '';
    var $largest_slug_len = 0;

    public function __construct($folder,$version){

        $this->version = $version;
        $this->process_folder($folder);

        echo( count($this->data) . ' Organizations parsed<br/>' );
        echo( "largest_slug => $this->largest_slug<br/>" );
        echo( "largest_slug_len => $this->largest_slug_len<br/>" );
    }

    public function newObject($object){

        $newObject = (object)array(
                'version' => (int)$this->version,
                'id' => (int)$object->orgid,
                'organization' => (string)$object->charity_name,
                'slug' => CN_Common::slugify((string)$object->charity_name),
                'mission' => (string)$object->mission,
                'category' => (string)$object->category,
                'cause' => (string)$object->cause,
                'resource_uri' => (string)$object->resource_uri       
            );

        echo("<span id='organization-$newObject->id'>Organization: $newObject->organization ($newObject->id) => $newObject->slug </span><br/>");     

        $this->data[] = $newObject;

        $slug_len = strlen($newObject->slug);
        if( $slug_len > $this->largest_slug_len ){
            $this->largest_slug = $newObject->slug;
            $this->largest_slug_len = $slug_len;
        }
    }

    public function isFile($pathinfo){
        return strstr($pathinfo['filename'], 'organizations-') == false ? false : true;
    }

    public function findByName($name){
        foreach ($this->data as $item) {
            if( $item->organization === $name ){
                return $item;
            }
        }
        return null;
    }

    public function findByUri($resource_uri){
        foreach ($this->data as $item) {
            if( $item->resource_uri === $resource_uri ){
                return $item;
            }
        }
        return null;
    }

    public function linkWithCategories( $categories ){
        foreach ($this->data as $item) {
            $category = $categories->findByName($item->category);
            if( $category == null ){
                die("<p style='color:red;'>************* ERROR: Category '$item->category' for Organization '$item->organization' not found!<p>");
            }
            $item->categoryid = $category->id;
            echo "$item->organization > $item->category > $item->categoryid <br/>";
        }
    }

    public function linkWithCauses( $causes ){
        foreach ($this->data as $item) {
            $cause = $causes->findByName($item->cause);
            if( $cause == null ){
                die("<p style='color:red;'>************* ERROR: Cause '$item->cause' for Organization '$item->organization' not found!<p>");
            }
            $item->causeid = $cause->id;
            echo "$item->organization > $item->cause > $item->causeid <br/>";
        }
    }
}

