<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CN_Country {

    var $regionRef = null;
    var $organizationRefs = array();

    public function __construct( $simpleXmlElement ){

        $this->countryid = (int)$simpleXmlElement->countryid;
        $this->country = (string)$simpleXmlElement->country;
        $this->regionid = (int)CN_Common::extractIdFromUri( (string)$simpleXmlElement->regionid );
        $this->charity_count = (int)$simpleXmlElement->charity_count;
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;

        $this->slug = CN_Common::slugify( $this->country );

        $this->name = $this->country;
    }
}


