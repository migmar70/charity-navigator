<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class CN_SearchResult {

    var $organizationRef;

    public function __construct( $simpleXmlElement ){

        $this->category = (string)$simpleXmlElement->Category;
        $this->city = (string)$simpleXmlElement->city;
        $this->overallrtg = (string)$simpleXmlElement->OverallRtg;
        $this->charity_name = (string)$simpleXmlElement->Charity_Name;
        $this->overallscore = (string)$simpleXmlElement->OverallScore;
        $this->state = (string)$simpleXmlElement->state;
        $this->orgid = (int)$simpleXmlElement->OrgId;
        $this->rank = (string)$simpleXmlElement->Rank;
        $this->ein = (string)$simpleXmlElement->ein;
        $this->cause = (string)$simpleXmlElement->Cause;
        $this->tag_line = (string)$simpleXmlElement->Tag_Line;
    }
}


