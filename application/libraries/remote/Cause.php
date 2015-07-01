<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CN_Cause {

    var $organizationRefs = array();
	var $categoryRef;

    public function __construct( $simpleXmlElement ){

        $this->causeid = (int)$simpleXmlElement->causeid;
        $this->cause = (string)$simpleXmlElement->cause;
        $this->description = (string)$simpleXmlElement->description;
		$this->category = (string)$simpleXmlElement->category;
		$this->categoryid = (int)CN_Common::extractIdFromUri((string)$simpleXmlElement->categoryid);
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;

        $this->slug = CN_Common::slugify( $this->cause );

        $this->name = $this->cause;
    }
}


