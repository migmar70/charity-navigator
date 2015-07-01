<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CN_List {

    var $organizationRefs = array();

    public function __construct( $simpleXmlElement ){

        $this->listname = (string)$simpleXmlElement->listname;
        $this->description = (string)$simpleXmlElement->description;
        $this->typeid = (int)$simpleXmlElement->typeid;
        $this->listid = (int)$simpleXmlElement->listid;
        $this->list_type = (string)$simpleXmlElement->list_type;
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;

        $this->slug = CN_Common::slugify( $this->listname );
        $this->name = $this->listname;
        $this->sort = $this->listname[0];
    }
}
