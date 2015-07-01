<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class CN_Organization {

    var $listRefs = array();
    var $categoryRef;
    var $causeRef;
    var $searchResultRefs = array();
    var $countryRefs = array();
    var $celebrityRefs = array();

    public function __construct( $simpleXmlElement ){

        $this->orgid = (int)$simpleXmlElement->orgid;

        $this->charity_name = (string)$simpleXmlElement->charity_name;
        $this->slug = CN_Common::slugify( $this->charity_name );
        $this->name = $this->charity_name;

        $this->category = (string)$simpleXmlElement->category;
        $this->cause = (string)$simpleXmlElement->cause;
        
        $this->ein                                  = (string)$simpleXmlElement->ein;
        $this->tag_line                             = (string)$simpleXmlElement->tag_line;
        $this->fundraising_efficiency               = (string)$simpleXmlElement->fundraising_efficiency;    // 0.170000000000000 DECIMAL(12,4)
        $this->fundraising_expenses_ratio           = (string)$simpleXmlElement->fundraising_expenses_ratio;
        $this->program_expenses_ratio               = (string)$simpleXmlElement->program_expenses_ratio;
        $this->administration_expenses_ratio        = (string)$simpleXmlElement->administration_expenses_ratio;
        $this->primary_revenue_growth               = (string)$simpleXmlElement->primary_revenue_growth;
        $this->program_expenses_growth              = (string)$simpleXmlElement->program_expenses_growth;
        $this->working_capital_ratio                = (string)$simpleXmlElement->working_capital_ratio;
        $this->mission                              = (string)$simpleXmlElement->mission;
        $this->street_address_1                     = (string)$simpleXmlElement->street_address_1;
        $this->street_address_2                     = (string)$simpleXmlElement->street_address_2;
        $this->city                                 = (string)$simpleXmlElement->city;
        $this->state                                = (string)$simpleXmlElement->state;
        $this->zip                                  = (string)$simpleXmlElement->zip;
        $this->cob_name                             = (string)$simpleXmlElement->cob_name;
        $this->cob_title                            = (string)$simpleXmlElement->cob_title;
        $this->current_ceo_name                     = (string)$simpleXmlElement->current_ceo_name;
        $this->current_ceo_title                    = (string)$simpleXmlElement->current_ceo_title;
        $this->financial_score                      = (string)$simpleXmlElement->financial_score;
        $this->financial_rating                     = (string)$simpleXmlElement->financial_rating;
        $this->accountability_score                 = (string)$simpleXmlElement->accountability_score;
        $this->accountability_rating                = (string)$simpleXmlElement->accountability_rating;
        $this->overall_score                        = (string)$simpleXmlElement->overall_score;
        $this->overall_rating                       = (string)$simpleXmlElement->overall_rating;
        $this->fundraising_expenses                 = (string)$simpleXmlElement->fundraising_expenses;
        $this->administration_expenses              = (string)$simpleXmlElement->administration_expenses; // DECIMAL(12,4)
        $this->program_expenses                     = (string)$simpleXmlElement->program_expenses;
        $this->total_expenses                       = (string)$simpleXmlElement->total_expenses;
        $this->total_revenue                        = (string)$simpleXmlElement->total_revenue;             //DECIMAL(12,4)
        $this->total_net_assets                     = (string)$simpleXmlElement->total_net_assets;
        $this->boardlist_status                     = (string)$simpleXmlElement->boardlist_status;
        $this->stafflist_status                     = (string)$simpleXmlElement->stafflist_status;
        $this->auditedfinancial_status              = (string)$simpleXmlElement->auditedfinancial_status;
        $this->form990_status                       = (string)$simpleXmlElement->form990_status;
        $this->privacy_status                       = (string)$simpleXmlElement->privacy_status;
        $this->loanstoorfromofficers                = (string)$simpleXmlElement->loanstoorfromofficers;
        $this->loanstoofficers                      = (string)$simpleXmlElement->loanstoofficers;
        $this->materialdiversionofassets            = (string)$simpleXmlElement->materialdiversionofassets;
        $this->boardmeetingminutes                  = (string)$simpleXmlElement->boardmeetingminutes;
        $this->distributes990toboard                = (string)$simpleXmlElement->distributes990toboard;
        $this->conflictofinterestpolicy             = (string)$simpleXmlElement->conflictofinterestpolicy;
        $this->whistleblowerpolicy                  = (string)$simpleXmlElement->whistleblowerpolicy;
        $this->recordsretentionpolicy               = (string)$simpleXmlElement->recordsretentionpolicy;
        $this->reportsceoandsalary                  = (string)$simpleXmlElement->reportsceoandsalary;
        $this->ceocompensationprocedure             = (string)$simpleXmlElement->ceocompensationprocedure;
        $this->compensatesboard                     = (string)$simpleXmlElement->compensatesboard;
        $this->independentaudit                     = (string)$simpleXmlElement->independentaudit;
        $this->boardcomposition                     = (string)$simpleXmlElement->boardcomposition;

        $this->resource_uri = (string)$simpleXmlElement->resource_uri;
    }
}


