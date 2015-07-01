<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CN_Region {

	var $countryRefs = array();

    public function __construct( $simpleXmlElement ){

        $this->regionid = (int)$simpleXmlElement->regionid;
        $this->region = (string)$simpleXmlElement->region;
        $this->charity_count = (int)$simpleXmlElement->charity_count;
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;

        $this->slug = CN_Common::slugify( $this->region );

        $this->name = $this->region;
    }
}


