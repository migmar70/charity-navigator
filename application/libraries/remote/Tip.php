<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CN_Tip {

    public function __construct( $listname, $description, $typeid, $listid, $list_type, $resource_uri ){

        $this->listname = (string)$listname;
        $this->description = (string)$description;
        $this->typeid = (int)$typeid;
        $this->listid = (int)$listid;
        $this->list_type = (string)$list_type;
        $this->resource_uri = (string)$resource_uri;

        $this->slug = CN_Common::slugify( $this->listname );
        $this->name = $this->listname;
    }
}
