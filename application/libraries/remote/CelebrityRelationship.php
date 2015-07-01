<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CN_CelebrityRelationship {

    public function __construct( $simpleXmlElement ){

        $this->relationshipid = (int)$simpleXmlElement->relationshipid;
        $this->relationship = (string)$simpleXmlElement->relationship;
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;

        $this->slug = CN_Common::slugify( $this->relationship );
        
        $this->name = $this->relationship;
    }
}


