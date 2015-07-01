<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CN_CountryOrganization {

    var $countryRef = null;
    var $organizationRef = null;

    public function __construct( $simpleXmlElement ){
        $this->countryid = (int)CN_Common::extractIdFromUri( (string)$simpleXmlElement->countryid );
        $this->country = (string)$simpleXmlElement->country;
        $this->region = (string)$simpleXmlElement->region;
        $this->charity_name = (string)$simpleXmlElement->charity_name;
        $this->orgid = (int)CN_Common::extractIdFromUri( (string)$simpleXmlElement->orgid );
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;
    }
}


