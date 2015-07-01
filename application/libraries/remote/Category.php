<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CN_Category {

	var $organizationRefs = array();
	var $causeRefs = array();

    public function __construct( $simpleXmlElement ){

        $this->categoryid = (int)$simpleXmlElement->categoryid;
        $this->category = (string)$simpleXmlElement->category;
        $this->description = (string)$simpleXmlElement->description;
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;

        $this->slug = CN_Common::slugify( $this->category );

        $this->name = $this->category;
    }
}


