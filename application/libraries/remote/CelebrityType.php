<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CN_CelebrityType {

    var $celebrityRefs = array();

    public function __construct( $simpleXmlElement ){

        $this->typeid = (int)$simpleXmlElement->typeid;
        $this->type = (string)$simpleXmlElement->type;
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;

        $this->slug = CN_Common::slugify( $this->type );

        $this->name = $this->type;

    }
}


