<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CN_Celebrity {

    var $celebrityTypeRef;
    var $organizationRefs = array();

    public function __construct( $simpleXmlElement ){

        $this->celebrityid = (int)$simpleXmlElement->celebrityid;
        $this->fname = (string)$simpleXmlElement->fname;
		$this->mname = (string)$simpleXmlElement->mname;
		$this->lname = (string)$simpleXmlElement->lname;
        $this->name = (string)$simpleXmlElement->name;
        $this->charity_count = (int)$simpleXmlElement->charity_count;
        $this->type = (string)$simpleXmlElement->type;
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;

        $this->slug = CN_Common::slugify( $this->name );

    }
}


