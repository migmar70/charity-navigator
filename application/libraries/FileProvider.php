<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



require_once(dirname(__FILE__).'/Common.php'); 

require_once(dirname(__FILE__).'/file/FileLoader.php'); 
require_once(dirname(__FILE__).'/file/Categories.php'); 
require_once(dirname(__FILE__).'/file/Causes.php'); 
require_once(dirname(__FILE__).'/file/Regions.php'); 
require_once(dirname(__FILE__).'/file/Countries.php'); 
require_once(dirname(__FILE__).'/file/CelebrityTypes.php'); 
require_once(dirname(__FILE__).'/file/CelebrityRelationships.php'); 
require_once(dirname(__FILE__).'/file/Celebrities.php'); 
require_once(dirname(__FILE__).'/file/Organizations.php'); 
require_once(dirname(__FILE__).'/file/CelebrityOrganizations.php');
require_once(dirname(__FILE__).'/file/CountryOrganizations.php');

class CN_FileProvider {

    var $data = array();

    public function __construct(){
        $this->folder = FCPATH.'public/content/data/';
    }

    public function load(){
        $version = 1;
        //
        // Categories
        //
        $categories = new CN_Categories( $this->folder, $version );

        //
        // Causes

        $causes = new CN_Causes( $this->folder, $version );

        $causes->linkWithCategories( $categories );

        //
        // Regions

        $regions = new CN_Regions( $this->folder, $version );

        //
        // Countries
        //
        $countries = new CN_Countries( $this->folder, $version );

        $countries->linkWithRegions( $regions );

        //
        // Celebrity Types

        $celebrityTypes = new CN_CelebrityTypes( $this->folder, $version );

        //
        // Celebrity Relationships

        $celebrityRelationships = new CN_CelebrityRelationships( $this->folder, $version );

        //
        // Celebrities
        echo '<p id="celebrities" style="font-weight:bold;">Celebrities<p>';

        $celebrities = new CN_Celebrities( $this->folder, $version );

        $celebrities->linkWithTypes( $celebrityTypes );


        //
        // Organizations

        echo '<p id="organizations" style="font-weight:bold;">Organizations<p>';

        $organizations = new CN_Organizations( $this->folder, $version );

        echo '<p id="link-with-categories" style="font-weight:bold;">Link with Categories<p>';
        $organizations->linkWithCategories( $categories );

        echo '<p id="link-with-causes" style="font-weight:bold;">Link with Causes<p>';
        $organizations->linkWithCauses( $causes );

        //
        // Celebrity Organizations
        echo '<p id="celebrity-organizations" style="font-weight:bold;">Celebrity Organizations<p>';

        $celebrityOrganizations = new CN_CelebrityOrganizations( $this->folder, $version );

        $celebrityOrganizations->linkWithOrganizations( $organizations );
        //$celebrityOrganizations->linkWithCelebrities( $celebrities );
        //$celebrityOrganizations->linkWithCelebrityRelationships( $celebrityRelationships );

        //
        // Country Organizations

        echo '<p id="country-organizations" style="font-weight:bold;">Country Organizations<p>';

        $countryOrganizations = new CN_CountryOrganizations( $this->folder, $version );

    }

}

