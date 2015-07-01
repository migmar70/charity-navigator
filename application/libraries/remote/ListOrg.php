<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CN_ListOrg {

    var $listRef;
    var $organizationRef;

    public function __construct( $simpleXmlElement ){
        $this->typeid = (int)$simpleXmlElement->typeid;
        $this->rank = (int)$simpleXmlElement->rank;
        $this->charity_url = (string)$simpleXmlElement->charity_url;
        $this->value_label = (string)$simpleXmlElement->value_label;
        $this->charity_name = (string)$simpleXmlElement->charity_name;
        $this->listid = (int)$simpleXmlElement->listid;
        $this->value = (string)$simpleXmlElement->value;
        $this->list_type = (string)$simpleXmlElement->list_type;
        $this->resource_uri = (string)$simpleXmlElement->resource_uri;
        $this->listname = (string)$simpleXmlElement->listname;
        $this->ein = (string)$simpleXmlElement->ein;
        $this->orgid = (int)$this->getOrgId();
    }

    public function getOrgId(){
    	$pos = strpos($this->charity_url,'orgid=');
    	return substr($this->charity_url, $pos+6);
    }
}


