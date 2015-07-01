<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CN_CelebrityOrganization {

    var $celebrityRef;
    var $organizationRef;
    var $celebrityRelationshipRef;

    public function __construct( $simpleXmlElement ){

        $this->typeid = (int)$simpleXmlElement->typeid;
        $this->relationship = (string)$simpleXmlElement->relationship;
        $this->mname = (string)$simpleXmlElement->mname;
        $this->charity_name = (string)$simpleXmlElement->charity_name;
        $this->relationshipid = (string)$simpleXmlElement->relationshipid; // url
        $this->lname = (string)$simpleXmlElement->lname;
        $this->orgid = (int)CN_Common::extractIdFromUri((string)$simpleXmlElement->orgid); // url
        $this->fname = (string)$simpleXmlElement->fname;
        $this->celebrityid = (string)$simpleXmlElement->celebrityid; // url
        $this->type = (string)$simpleXmlElement->type;
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;

		$this->name = (string)$simpleXmlElement->name;
        $this->slug = (string)$simpleXmlElement->slug;

        $this->celebrity = CN_Common::namefy( $this->fname, $this->mname, $this->lname );
    }
}


