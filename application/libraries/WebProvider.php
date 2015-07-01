<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



require_once(dirname(__FILE__).'/Common.php'); 

require_once(dirname(__FILE__).'/remote/Downloader.php'); 
require_once(dirname(__FILE__).'/remote/List.php'); 
require_once(dirname(__FILE__).'/remote/ListOrg.php'); 
require_once(dirname(__FILE__).'/remote/Organization.php'); 
require_once(dirname(__FILE__).'/remote/SearchResult.php'); 
require_once(dirname(__FILE__).'/remote/Category.php'); 
require_once(dirname(__FILE__).'/remote/Cause.php'); 
require_once(dirname(__FILE__).'/remote/CelebrityType.php'); 
require_once(dirname(__FILE__).'/remote/Celebrity.php'); 
require_once(dirname(__FILE__).'/remote/CelebrityRelationship.php'); 
require_once(dirname(__FILE__).'/remote/CelebrityOrganization.php'); 
require_once(dirname(__FILE__).'/remote/Country.php'); 
require_once(dirname(__FILE__).'/remote/Region.php'); 
require_once(dirname(__FILE__).'/remote/CountryOrganization.php'); 
require_once(dirname(__FILE__).'/remote/Tip.php'); 

class CN_WebProvider {

    var $lists = array();
    var $listOrgs = array();

    var $toptenlistsOrgs = array();
    var $searchresults = array();
    var $organizations = array();
    var $categories = array();
    var $causes = array();
    var $celebrities = array();
    var $celebrityTypes = array();
    var $celebrityRelationships = array();
    var $celebrityOrganizations = array();
    var $countries = array();
    var $regions = array();
    var $slugs = array();

    var $version = 0;

    public function __construct( $app_id, $app_key, $version ){
        $this->version = $version;
        $this->downloader = new CN_Downloader( $app_id, $app_key, $version );
    }

    public function load( $model ){

        $this->getRegions( $model );
        $this->getCountries( $model );
        $this->getCategories( $model );
        $this->getCauses( $model );

        $this->getCelebrityTypes( $model );
        $this->getCelebrities( $model );
        $this->getCelebrityRelationships( $model );

        $this->getLists( $model );

        $this->search( $model );

        echo '<p style="color:red:font-weight:bold;font-size:2em;">'. count($this->organizations).' organizations after search...</p>';

        $this->getCelebrityOrganizations( $model );

        $this->getCountryOrganizations( $model );

        $this->getTips( $model );
  
        $this->getMethodology( $model );

        echo '<p style="color:red:font-weight:bold;font-size:2em;">'. count($this->organizations).' total organizations...</p>';

    }

    public function getOrganizationById( $orgid, $model ){

        if( isset($this->organizations[$orgid]) ){
            echo '<p style="color:green">getOrganizationById( '.$orgid.' ) found with slug '.$this->organizations[$orgid]->slug.'</p>';
            return;
        }


        $simpleXmlElements = $this->downloader->downloadXml( 'organizations', 'charity_name', array('orgid' => $orgid) );

        foreach ($simpleXmlElements as $simpleXmlElement) {

            $organization = new CN_Organization($simpleXmlElement);

            $this->organizations[$organization->orgid] = $organization;

            echo( 'getOrganizationById('.$organization->orgid.') = '.$organization->slug.'<br/>' );

            $category = $this->categories[ CN_Common::slugify( $organization->category ) ];
            $cause = $this->causes[ CN_Common::slugify( $organization->cause ) ];

            $organization->categoryRef = $category;
            $organization->categoryRef->organizationRefs[] = $organization;

            $organization->causeRef = $cause;
            $organization->causeRef->organizationRefs[] = $organization;

            $this->slugs[ $organization->slug ] = $organization;

            if( $model != null ){
                $model->saveOrganization( $organization, $this->version );
            }
        }
    }    

    public function getRegions( $model ){

        echo '<p id="getRegions" style="font-weight:bold;">Regions<p>';

        $simpleXmlElements = $this->downloader->downloadXml( 'regions', 'region', null );
        
        echo( 'getRegions '.count($simpleXmlElements) . ' Regions parsed<br/>' );

        foreach ($simpleXmlElements as $simpleXmlElement) {

            $region = new CN_Region( $simpleXmlElement );

            $this->regions[ $region->regionid ] = $region;

            $this->slugs[ $region->slug ] = $region;

            echo "getRegions $region->regionid | $region->slug<br/>";

            if( $model != null ){
                $model->saveRegion( $region, $this->version );
            }
        }
    }

    public function getCountries( $model ){

        echo '<p id="countries" style="font-weight:bold;">Countries<p>';

        $simpleXmlElements = $this->downloader->downloadXml( 'countries', 'country', null );
        
        echo( 'getCountries '.count($simpleXmlElements) . ' Countries parsed<br/>' );

        foreach ($simpleXmlElements as $simpleXmlElement) {
            $country = new CN_Country( $simpleXmlElement );

            $this->countries[ $country->slug ] = $country;

            $this->slugs[ $country->slug ] = $country;
            
            echo "getCountries $country->countryid | $country->slug<br/>";

            $country->regionRef = $this->regions[ $country->regionid ];
            $country->regionRef->countryRefs[] = $country;

            if( $model != null ){
                $model->saveCountry( $country, $this->version );
            }
        }
    }

    public function getCategories( $model ){

        echo '<p id="getCategories" style="font-weight:bold;">Categories<p>';

        $simpleXmlElements = $this->downloader->downloadXml( 'categories', 'category', null );
        
        echo( 'getCategories '.count($simpleXmlElements) . ' Categories parsed<br/>' );

        foreach ($simpleXmlElements as $simpleXmlElement) {
            $category = new CN_Category( $simpleXmlElement );
            $this->categories[$category->slug] = $category;
            echo "getCategories $category->categoryid | $category->slug<br/>";
            $this->slugs[ $category->slug ] = $category;

            if( $model != null ){
                $model->saveCategory( $category, $this->version );
            }
        }
    }

    public function getCauses( $model ){

        echo '<p id="getCauses" style="font-weight:bold;">Causes<p>';

        $simpleXmlElements = $this->downloader->downloadXml( 'causes', 'cause', null );
        
        echo( 'getCauses '.count($simpleXmlElements) . ' Causes parsed<br/>' );

        foreach ($simpleXmlElements as $simpleXmlElement) {
            $cause = new CN_Cause( $simpleXmlElement );
            $this->causes[$cause->slug] = $cause;

            echo "getCauses $cause->categoryid | $cause->causeid | $cause->slug<br/>";

            $cause->categoryRef = $this->categories[ CN_Common::slugify($cause->category) ];
            $cause->categoryRef->causeRefs[] = $cause;

            $this->slugs[ $cause->slug ] = $cause;

            if( $model != null ){
                $model->saveCause( $cause, $this->version );
            }
        }
    }

    public function getCelebrityTypes( $model ){

        echo '<p id="getCelebrityTypes" style="font-weight:bold;">Celebrity Types<p>';

        $simpleXmlElements = $this->downloader->downloadXml( 'celebrities-types', 'type', null );
        
        echo( '+ '.count($simpleXmlElements) . ' Celebrity Types parsed<br/>' );

        foreach ($simpleXmlElements as $simpleXmlElement) {
            $celebrityType = new CN_CelebrityType( $simpleXmlElement );
            
            $this->celebrityTypes[ $celebrityType->slug ] = $celebrityType;

            echo "getCelebrityTypes $celebrityType->typeid | $celebrityType->slug<br/>";

            $this->slugs[ $celebrityType->slug ] = $celebrityType;

            if( $model != null ){
                $model->saveCelebrityType( $celebrityType, $this->version );
            }
        }
    }

    public function getCelebrities( $model ){

        echo '<p id="getCelebrities" style="font-weight:bold;">Celebrities<p>';

        $simpleXmlElements = $this->downloader->downloadXml( 'celebrities', 'name', null );
        
        echo( '+ '.count($simpleXmlElements) . ' Celebrities parsed<br/>' );

        foreach ($simpleXmlElements as $simpleXmlElement) {
            $celebrity = new CN_Celebrity( $simpleXmlElement );
            $this->celebrities[$celebrity->slug] = $celebrity;

            $celebrity->celebrityTypeRef = $this->celebrityTypes[ CN_Common::slugify($celebrity->type) ];
            $celebrity->celebrityTypeRef->celebrityRefs[] = $celebrity;

            echo 'getCelebrities '.$celebrity->celebrityid.' | '.$celebrity->slug.' | '.$celebrity->celebrityTypeRef->name.' <br/>';

            $this->slugs[ $celebrity->slug ] = $celebrity;

            if( $model != null ){
                $model->saveCelebrity( $celebrity, $this->version );
            }
        }
    }

    public function getCelebrityRelationships( $model ){

        echo '<p id="getCelebrityRelationships" style="font-weight:bold;">Celebrity Relationships<p>';

        $simpleXmlElements = $this->downloader->downloadXml( 'celebrity-relationships', 'relationship', null );
        
        echo( '+ '.count($simpleXmlElements) . ' Celebrity Relationships parsed<br/>' );

        foreach ($simpleXmlElements as $simpleXmlElement) {
            $celebrityRelationship = new CN_CelebrityRelationship( $simpleXmlElement );

            $this->celebrityRelationships[ $celebrityRelationship->slug ] = $celebrityRelationship;

            echo 'getCelebrityRelationships '.$celebrityRelationship->relationshipid.' | '.$celebrityRelationship->slug.' <br/>';

            $this->slugs[ $celebrityRelationship->slug ] = $celebrityRelationship;

            if( $model != null ){
                $model->saveCelebrityRelationship( $celebrityRelationship, $this->version );
            }
        }
    }

    public function getLists( $model ){

        echo '<p id="getLists" style="font-weight:bold;">Lists<p>';

        $simpleXmlElements = $this->downloader->downloadXml( 'lists', 'listname', null );
        
        echo( '+ '.count($simpleXmlElements) . ' Lists parsed<br/>' );
        
        foreach ($simpleXmlElements as $simpleXmlElement) {
            $list = new CN_List($simpleXmlElement);
            
            $this->lists[ $list->slug ] = $list;
            $this->slugs[ $list->slug ] = $list;

            echo "getLists() = $list->listid | $list->slug<br/>";

            if( $model != null ){
                $model->saveList( $list, $this->version );
            }

            $this->getListOrgsByList( $list, $model );
        }
    }

    public function getListOrgsByList( $list, $model ){

        $simpleXmlElements = $this->downloader->downloadXml( 'lists-orgs', 'listname', array('listid' => $list->listid) );

        foreach ($simpleXmlElements as $simpleXmlElement) {

            $listOrg = new CN_ListOrg($simpleXmlElement);
            
            $this->listOrgs[] = $listOrg;

            $listOrg->listRef = $list;

            $this->getOrganizationById( $listOrg->orgid, $model ); // result will be added to $this->organizations[]

            $organization = $this->organizations[ $listOrg->orgid ];

            $listOrg->organizationRef = $organization;

            $organization->listRefs[] = $list;

            if( $model != null ){
                $model->saveListOrganization( $listOrg, $this->version );
            }

        }
    }

    public function search( $model ){

        //http://api.charitynavigator.org/api/v1/search/?app_key=APP_KEY&app_id=APP_ID&field=value

        $letters = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

        foreach ($letters as $letter) {
            $simpleXmlElements = $this->downloader->downloadXml( 'search', 'charity_name', array('letter' => $letter) );

            foreach ($simpleXmlElements as $simpleXmlElement) {

                $searchresult = new CN_SearchResult( $simpleXmlElement );

                $this->searchresults[] = $searchresult;

                $this->getOrganizationById( $searchresult->orgid, $model ); // result will be added to $this->organizations[]

                $searchresult->organizationRef = $this->organizations[ $searchresult->orgid ];

                $searchresult->organizationRef->searchResultRefs[] = $searchresult;
            }
        }
    }

    public function getCelebrityOrganizations( $model ){

        echo '<p id="getCelebrityOrganizations" style="font-weight:bold;">Celebrity Organizations<p>';

        $simpleXmlElements = $this->downloader->downloadXml( 'celebrity-orgs', 'name', null );
        
        echo( 'getCelebrityOrganizations '.count($simpleXmlElements) . ' Celebrity Organizations parsed<br/>' );

        foreach ($simpleXmlElements as $simpleXmlElement) {

            $celebrityOrganization = new CN_CelebrityOrganization( $simpleXmlElement );

            $this->celebrityOrganizations[] = $celebrityOrganization;

            $this->getOrganizationById( $celebrityOrganization->orgid, $model );

            $celebrityOrganization->celebrityRef = $this->celebrities[ CN_Common::slugify($celebrityOrganization->celebrity) ];
            $celebrityOrganization->organizationRef = $this->organizations[ $celebrityOrganization->orgid ];
            $celebrityOrganization->celebrityRelationshipRef = $this->celebrityRelationships[ CN_Common::slugify($celebrityOrganization->relationship) ];

            echo( 'getCelebrityOrganizations '.$celebrityOrganization->celebrityRef->slug. ' | '.$celebrityOrganization->organizationRef->slug.' | '.$celebrityOrganization->celebrityRelationshipRef->slug.' <br/>' );

            $celebrityOrganization->celebrityRef->organizationRefs[] = $celebrityOrganization->organizationRef;
            $celebrityOrganization->organizationRef->celebrityRefs[] = $celebrityOrganization->celebrityRef;

            if( $model != null ){
                $model->saveCelebrityOrganization( $celebrityOrganization, $this->version );
            }
        }
    }

    public function getCountryOrganizations( $model ){

        echo '<p id="countryorganizations" style="font-weight:bold;">COUNTRY ORGANIZATIONS<p>';

        $simpleXmlElements = $this->downloader->downloadXml( 'country-orgs', 'country', null );
        
        echo 'getCountryOrganizations '.count($simpleXmlElements) . ' Countries Organizations<br/>';
        
        foreach ($simpleXmlElements as $simpleXmlElement) {

            $countryOrganization = new CN_CountryOrganization( $simpleXmlElement );
            $this->countryOrganizations[] = $countryOrganization;

            $this->getOrganizationById( $countryOrganization->orgid, $model );

            $countryOrganization->countryRef = $this->countries[ CN_Common::slugify($countryOrganization->country) ];
            $countryOrganization->organizationRef = $this->organizations[ $countryOrganization->orgid ];

            $countryOrganization->countryRef->organizationRefs[] = $countryOrganization->organizationRef;
            $countryOrganization->organizationRef->countryRefs[] = $countryOrganization->countryRef;

            echo 'getCountryOrganizations '.$countryOrganization->countryRef->slug.' | '.$countryOrganization->organizationRef->slug.'<br/>';

            if( $model != null ){

                echo 'getCountryOrganizations <span style="color:blue;font-weight:bold;font-size:2em;">SAVING COUNTRY ORGANIZATION '.$countryOrganization->countryRef->slug.' | '.$countryOrganization->organizationRef->slug.'</span><br/>';

                $model->saveCountryOrganization( $countryOrganization, $this->version );
            }
        }

        echo 'getCountryOrganizations '.count($simpleXmlElements) . ' COUNTRY ORGANIZATIONS SAVED!!!<br/>';
    }

    public function getCountryOrganizationsNew( $model ){ 

        echo "<p id=\"getCountryOrganizations\" style=\"font-weight:bold;\">COUNTRY ORGANIZATIONS<p>";

        foreach ($this->countries as $country ) {
            
            $simpleXmlElements = $this->downloader->downloadXml( 'country-orgs', 'country', array('countryid' => $country->countryid) );
            
            foreach ($simpleXmlElements as $simpleXmlElement) {

                $countryOrganization = new CN_CountryOrganization( $simpleXmlElement );
                $this->countryOrganizations[] = $countryOrganization;

                $this->getOrganizationById( $countryOrganization->orgid, $model );

                $countryOrganization->countryRef = $this->countries[ CN_Common::slugify($countryOrganization->country) ];
                $countryOrganization->organizationRef = $this->organizations[ $countryOrganization->orgid ];

                $countryOrganization->countryRef->organizationRefs[] = $countryOrganization->organizationRef;
                $countryOrganization->organizationRef->countryRefs[] = $countryOrganization->countryRef;

                echo 'getCountryOrganizations '.$countryOrganization->countryRef->slug.' | '.$countryOrganization->organizationRef->slug.'<br/>';

                if( $model != null ){
                    $model->saveCountryOrganization( $countryOrganization, $this->version );
                }
            }


        }
    }

    public function getTips( $model ){

        $nextlistid = 20000;

        $items = array(
            
            array(
                "listid" => (++$nextlistid),
                "typeid" => 20000,
                "list_type" => "Donor Tip",
                "resource_uri" => "",
                "listname" => "Be Proactive In Your Giving",
                "description" => "Smart givers generally don't give reactively in a knee-jerk fashion. They don't respond to the first organization that appeals for help. They take the time to identify which causes are most important to their families and they are specific about the change they want to affect. For example, they don't just support generic cancer charities, but instead have targeted goals for their giving, such as providing mammograms to at-risk women in their community.",
                "sort" => 'a'
            ),

            array(
                "listid" => (++$nextlistid),
                "typeid" => 20000,
                "list_type" => "Donor Tip",
                "resource_uri" => "",
                "listname" => "Hang Up The Phone / Eliminate The Middleman",
                "description" => "Informed donors recognize that for-profit fundraisers, those often used in charitable telemarketing campaigns, keep a large portion (in some cases all) of each dollar they collect (read our report about  telemarketing for more specifics on the costs affiliated with this form of fundraising). Wise donors never give out their personal information – like credit card accounts, social security numbers – over the phone. If they like what they hear in the pitch, they'll hang up, investigate the charity on-line and send their contribution directly to the charity, thereby cutting out the middleman and ensuring 100% of their donation reaches the charity. Taking it a step further, donors may want to reconsider supporting a charity that uses an inefficient telemarketing approach and instead identify a charity that does not use telemarketing to raise funds.",
                "sort" => ''
            ),

            array(
                "listid" => (++$nextlistid),
                "typeid" => 20000,
                "list_type" => "Donor Tip",
                "resource_uri" => "",
                "listname" => "Be Careful Of Sound-Alike Names",
                "description" => "Uninformed donors are easily confused by charities that have strikingly similar names to others. How many of us could tell the difference between an appeal from the Children's Charity Fund and the Children's Defense Fund? Their names sound the same, but their performances are vastly different. Would you be surprised to learn that the Children's Charity Fund is a 0-star charity while the Children's Defense Fund is a 3-star charity? Informed donors take the time to uncover the difference.",
                "sort" => 'b'
            ),

            array(
                "listid" => (++$nextlistid),
                "typeid" => 20000,
                "list_type" => "Donor Tip",
                "resource_uri" => "",
                "listname" => "Confirm 501(c) (3) Status",
                "description" => "Wise donors don't drop money into canisters at the checkout counter or hand over cash to solicitors outside the supermarket. Situations like these are irresistible to scam artists who wish to take advantage of your goodwill. Smart givers only support groups granted tax-exempt status under section 501(c) (3) of the Internal Revenue Code. All of the charities evaluated by Charity Navigator meet this basic requirement.",
                "sort" => 'c'
            ),

            array(
                "listid" => (++$nextlistid),
                "typeid" => 20000,
                "list_type" => "Donor Tip",
                "resource_uri" => "",
                "listname" => "Check The Charity's Commitment To Accountability & Transparency",
                "description" => "In 2011, Charity Navigator added an Accountability & Transparency dimension to its rating system. It tracks metrics such as whether the charity used an objective process to determine their CEO’s salary, whether it has an effective governance structure, and whether it has a whistleblower policy. This data is critical because charities that follow good governance and transparency practices are less likely to engage in unethical or irresponsible activities. So, the risk that such charities would misuse donations is lower than for charities that don't adopt such practices.",
                "sort" => 'd'
            ),

            array(
                "listid" => (++$nextlistid),
                "typeid" => 20000,
                "list_type" => "Donor Tip",
                "resource_uri" => "",
                "listname" => "Obtain Copies Of Its Financial Records",
                "description" => "Savvy donors know that the financial health of a charity is a strong indicator of the charity's programmatic performance. They know that in most cause areas, the most efficient charities spend 75% or more of their budget on their programs and services and less than 25% on fundraising and administrative fees. However, they also understand that mid-to-large sized charities do require a strong infrastructure therefore a claim of zero fundraising and/or administrative fees is unlikely at best. They understand that a charity's ability to sustain its programs over time is just as important as its short-term day-to-day spending practices. Therefore, savvy donors also seek out charities that are able to grow their revenue at least at the rate of inflation, that continue to invest in their programs and that have some money saved for a rainy day. All of this analysis is provided on Charity Navigator's website for free, but when considering groups not found here, savvy donors ask the charity for copies of its three most recent Forms 990. Not only can the donor examine the charity's finances, but the charity's willingness to send the documents is a good way to assess its commitment to transparency.",
                "sort" => ''
            ),

            array(
                "listid" => (++$nextlistid),
                "typeid" => 20000,
                "list_type" => "Donor Tip",
                "resource_uri" => "",
                "listname" => "Review Executive Compensation",
                "description" => "Sophisticated donors realize that charities need to pay their top leaders a competitive salary in order to attract and retain the kind of talent needed to run a multi-million dollar organization and produce results. But they also don't just take the CEO's compensation at face value; they benchmark it against similar-sized organizations engaged in similar work and located in the same region of the country. To help you make your own decision, Charity Navigator's analysis reveals that the average CEO's compensation of the charities we evaluate is almost $150,000. In general, salaries tend to be higher in the northeast and at arts and education charities. Sophisticated donors also put the CEO's salary into context by examining the overall performance of the organization. They know it is better to contribute to a charity with a well-paid CEO that is meeting its goals than to support a charity with an underpaid CEO that fails to deliver on its promises. (Check out our CEO Compensation Study for more benchmarking data.)",
                "sort" => 'e'
            ),

            array(
                "listid" => (++$nextlistid),
                "typeid" => 20000,
                "list_type" => "Donor Tip",
                "resource_uri" => "",
                "listname" => "Start A Dialogue To Investigate Its Programmatic Results",
                "description" => "Although it takes some effort on their part to assess a charity's programmatic impact, donors who are committed to advancing real change believe that it is worth their time. Before they make a contribution, they talk with the charity to learn about its accomplishments, goals and challenges. These donors are prepared to walk away from any charity that is unable or unwilling to participate in this type of conversation.",
                "sort" => 'f'
            ),

            array(
                "listid" => (++$nextlistid),
                "typeid" => 20000,
                "list_type" => "Donor Tip",
                "resource_uri" => "",
                "listname" => "Concentrate Your Giving",
                "description" => "When it comes to financial investments, diversification is the key to reducing risk. The opposite is true for philanthropic investments. If you've really taken the time to identify a well-run charity that is engaged in a cause that you are passionate about, you should then feel confident in giving it a donation. Spreading your money among multiple organizations not only results in your mail box filling up with more appeals, it also diminishes the possibility of any of those groups bringing about substantive change as each charity is wasting a percentage of your gift on processing expenses for that gift.",
                "sort" => 'g'
            ),

            array(
                "listid" => (++$nextlistid),
                "typeid" => 20000,
                "list_type" => "Donor Tip",
                "resource_uri" => "",
                "listname" => "Share Your Intentions And Make A Long-Term Commitment",
                "description" => "Smart donors support their favorite charities for the long haul. They see themselves as a partner in the charity's efforts to bring about change. They know that only with long-term, committed supporters can a charity be successful. And they don't hesitate to tell the charity of their giving plans so that the organization knows it can rely on the donor and the charity doesn't have to waste resources and harass the donor by sending numerous solicitations.",
                "sort" => 'h'
            )
        );

        foreach ($items as $item ) {

            $tip = new CN_Tip( $item['listname'], $item['description'], $item['typeid'], $item['listid'], $item['list_type'], $item['resource_uri']);

            if( $model != null ){
                $model->saveList( $tip, $this->version );
            }

        }
    }

    public function getMethodology( $model ){

        $nextlistid = 30000;

        $list = array(
                'What Kind of Charities Do We Evaluate?',
                'How Do We Classify Charities?',
                'How Do We Rate Charities?',
                'How Do We Rate Charities\' Financial Health?',
                'How Do We Rate Charities\' Accountability and Transparency?',
                'Accountability and Transparency Ratings Tables',
                'How Do We Calculate the Overall Score and Star Rating?',
                'What Do Our Ratings Mean?',
                'What Other Information Do We Present on the Charities We Evaluate?',
                'How Do We Decide To Post A Donor Advisory?',
                'How Do We Decide To Remove A Donor Advisory?',
                'Glossary-of-Terms'
            );
        $i = 0;
        foreach ($list as $item ) {
            $i++;
            $method = array(
                'listid' => (++$nextlistid),
                'typeid' => 30000,
                'list_type' => 'Methodology',
                'resource_uri' => '',
                'listname' => $item,
                'description' => '',
                'sort' => (string)$i
            );

            $tip = new CN_Tip( $method['listname'], $method['description'], $method['typeid'], $method['listid'], $method['list_type'], $method['resource_uri']);

            if( $model != null ){
                $model->saveList( $tip, $this->version );
            }
        }
    }
}

