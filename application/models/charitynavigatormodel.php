<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CharityNavigatorModel extends CI_Model {

	var $version;

	public function __construct(){
		parent::__construct();
	}

	public function getVersion(){
		$query = $this->db->query('SELECT version FROM version LIMIT 0, 1');
		foreach ($query->result() as $row) {
			$this->version = $row->version;
		}
		return $this->version;
	}

	public function getListBySlug( $slug ){
		$data = null;
		$query = $this->db->query('SELECT id, name, slug, description FROM list WHERE version = ? AND slug = ?', array($this->version,$slug));
		$results = $query->result();
		if( count($results) > 0 ){
			$data = $results[0];
		}
		return $data;
	}

	public function getListsByType( $type ){
		$query = $this->db->query('SELECT l.id, l.name, l.slug, l.description, (SELECT COUNT(*) FROM listorganization lo WHERE lo.version = l.version AND lo.listid = l.id) AS orgcount FROM list l WHERE l.version = ? AND l.type = ? ORDER BY sort ASC', array($this->version,$type) );
		return $query->result();
	}

	public function getTopTens(){
		return $this->getListsByType('Top Ten');
	}

	public function getHotTopics(){
		return $this->getListsByType('Article');
	}

	public function getTips(){
		return $this->getListsByType('Donor Tip');
	}

	public function getMethodology(){
		return $this->getListsByType('Methodology');
	}

	public function getListWithOrgs( $slug ){
		$list = $this->getListBySlug( $slug );
		$list->orgs = $this->getListOrganizations( $list->id );
		return $list;
	}

	public function getListOrganizations( $listid ){
		$data = array();
		$fields = array('l.rank, l.value_label, l.value, r.name, r.slug, r.mission');
		$query = 
			$this->db->query('SELECT '.implode(',', $fields).' FROM listorganization l LEFT OUTER JOIN organization r ON l.version = r.version AND l.organizationid =  r.id WHERE l.version = ? AND l.listid = ?', 
				array($this->version,$listid));
		foreach ( $query->result() as $row){
			$data[] = $row;
		}
		return $data;
	}

	public function getOrganizationBySlug( $slug ){
		$query = $this->db->query('SELECT id, name, slug, mission FROM organization WHERE version = ? AND slug = ? ORDER BY name ASC', array($this->version,$slug) );
		$results = $query->result();
		if( count($results) === 1){
			return $results[0];
		}
		return null;
	}

	public function getOrganizations(){
		$query = $this->db->query('SELECT id, name, slug FROM organization WHERE version = ? ORDER BY name ASC', array($this->version) );
		return $query->result();
	}

	public function getOrganizationsByCategoryId( $categoryid ){
		$data = array();
		$query = $this->db->query('SELECT id, name, slug, mission FROM organization WHERE version = ? AND categoryid = ? ORDER BY name ASC', array($this->version, $categoryid) );
		foreach( $query->result() as $result ){
			$data[] = $result;
		}
		return $data;
	}

	public function getOrganizationsByCauseId( $causeid ){
		$data = array();
		$query = $this->db->query('SELECT id, name, slug, mission FROM organization WHERE version = ? AND causeid = ? ORDER BY name ASC', array($this->version, $causeid) );
		foreach( $query->result() as $result ){
			$data[] = $result;
		}
		return $data;
	}

	public function getOrganizationsByCelebrityId( $celebirtyid ){
		$sqlStmt = 'SELECT o.id, o.name, o.slug, cr.name AS relationship ';
		$sqlStmt .= 'FROM celebrityorganization co ';
		$sqlStmt .= 'INNER JOIN organization o ON o.version = co.version AND o.id = co.organizationid ';
		$sqlStmt .= 'INNER JOIN celebrityrelationship cr ON cr.version = co.version AND cr.id = co.relationshipid ';
		$sqlStmt .= 'WHERE co.version = ? AND co.celebrityid = ? ';
		$sqlStmt .= 'ORDER BY o.name ASC ';

		$query = $this->db->query($sqlStmt, array($this->version, $celebirtyid) );
		return $query->result();
	}

	public function getOrganizationsByCountryId( $countryid ){
		$sqlStmt = 'SELECT o.id, o.name, o.slug ';
		$sqlStmt .= 'FROM countryorganization co ';
		$sqlStmt .= 'INNER JOIN organization o ON o.version = co.version AND o.id = co.organizationid ';
		$sqlStmt .= 'WHERE co.version = ? AND co.countryid = ? ';
		$sqlStmt .= 'ORDER BY o.name ASC ';

		$query = $this->db->query($sqlStmt, array($this->version, $countryid) );
		return $query->result();
	}

	public function getHotTopicBySlug( $slug ){
		return $this->getListBySlug( $slug );
	}

	public function getTipBySlug( $slug ){
		return $this->getListBySlug( $slug );
	}

	public function getMethodologyBySlug( $slug ){
		return $this->getListBySlug( $slug );
	}

	public function getCategories(){
		$data = array();
		$query = $this->db->query('SELECT c.id, c.name, c.slug, c.description, (SELECT COUNT(*) FROM organization o WHERE o.version = c.version AND o.categoryid = c.id) AS orgcount FROM category c WHERE c.version = ? ORDER BY c.name', array($this->version));
		foreach( $query->result() as $result ){
			$data[] = $result;
		}
		return $data;
	}

	public function getCategoryBySlug( $slug ){
		$data = null;
		$query = $this->db->query('SELECT id, name, slug FROM category WHERE version = ? and slug = ?', array($this->version, $slug));
		$results = $query->result();
		if( count($results) > 0 ){
			$data = $results[0];
		}
		return $data;
	}

	public function getCategoryBySlugWithOrganizations( $slug ){
		$category = $this->getCategoryBySlug( $slug );
		if( $category != null ){
			$category->orgs = $this->getOrganizationsByCategoryId( $category->id );
		}
		return $category;
	}

	public function getCauses(){
		$data = array();
		$query = $this->db->query('SELECT c.id, c.name, c.slug, c.description, (SELECT COUNT(*) FROM organization o WHERE o.version = c.version AND o.causeid = c.id) AS orgcount FROM cause c WHERE c.version = ? ORDER BY c.name', array($this->version));
		foreach( $query->result() as $result ){
			$data[] = $result;
		}
		return $data;
	}

	public function getCauseBySlug( $slug ){
		$data = null;
		$query = $this->db->query('SELECT id, name, slug FROM cause WHERE version = ? and slug = ?', array($this->version, $slug));
		$results = $query->result();
		if( count($results) > 0 ){
			$data = $results[0];
		}
		return $data;
	}

	public function getCauseBySlugWithOrganizations( $slug ){
		$cause = $this->getCauseBySlug( $slug );
		if( $cause != null ){
			$cause->orgs = $this->getOrganizationsByCauseId( $cause->id );
		}
		return $cause;
	}

	public function getCelebrities(){
		$query = $this->db->query('SELECT id, name, slug, orgcount FROM celebrity WHERE version = ? ORDER BY name', array($this->version));
		return $query->result();
	}

	public function getCelebrityBySlug( $slug ){
		$data = null;
		$query = $this->db->query('SELECT id, name FROM celebrity WHERE version = ? and slug = ?', array($this->version, $slug));
		$results = $query->result();
		if( count($results) > 0 ){
			$data = $results[0];
		}
		return $data;
	}

	public function getCelebrityBySlugWithOrganizations( $slug ){
		$celebrity = $this->getCelebrityBySlug( $slug );
		if( $celebrity != null ){
			$celebrity->orgs = $this->getOrganizationsByCelebrityId( $celebrity->id );
		}
		return $celebrity;
	}

	public function getCelebrityTypes(){
		$query = $this->db->query('SELECT id, name, slug FROM celebritytype WHERE version = ? ORDER BY name', array($this->version));
		return $query->result();
	}

	public function getCelebritiesByTypeId( $id ){

		$sqlStmt = 'SELECT c.id, c.name, c.slug, c.orgcount ';
		$sqlStmt .= 'FROM celebritytype ct ';
		$sqlStmt .= 'INNER JOIN celebrity c ON c.version = ct.version AND c.celebritytypeid = ct.id ';
		$sqlStmt .= 'WHERE ct.version = ? AND ct.id = ? ';
		$sqlStmt .= 'ORDER BY c.name ASC ';

		$query = $this->db->query($sqlStmt, array($this->version, $id) );

		return $query->result();
	}

	public function getCelebritiesByTypes(){
		$types = $this->getCelebrityTypes();
		foreach ($types as $type) {
			$type->celebrities = $this->getCelebritiesByTypeId( $type->id );
		}
		return $types;
	}

	public function getCelebrityRelationships(){
		$query = $this->db->query('SELECT id, name, slug FROM celebrityrelationship WHERE version = ? ORDER BY name', array($this->version));
		return $query->result();
	}

	public function getCelebritiesByRelationshipId( $id ){

		$sqlStmt = 'SELECT c.id, c.name, c.slug, c.orgcount ';
		$sqlStmt .= 'FROM celebrityorganization co ';
		$sqlStmt .= 'INNER JOIN celebrity c ON c.version = co.version AND c.id = co.celebrityid ';
		$sqlStmt .= 'WHERE co.version = ? AND co.relationshipid = ? ';
		$sqlStmt .= 'ORDER BY c.name ASC ';

		$query = $this->db->query($sqlStmt, array($this->version, $id) );

		return $query->result();
	}

	public function getCelebritiesByRelationships(){
		$relationships = $this->getCelebrityRelationships();
		foreach ($relationships as $relationship) {
			$relationship->celebrities = $this->getCelebritiesByRelationshipId( $relationship->id );
		}
		return $relationships;
	}

	public function getCountries(){
		$query = $this->db->query('SELECT id, name, slug, (SELECT COUNT(*) FROM countryorganization co WHERE co.version = c.version AND co.countryid = c.id) AS orgcount FROM country c WHERE version = ? ORDER BY name', array($this->version));
		return $query->result();
	}

	public function getCountryBySlug( $slug ){
		$query = $this->db->query('SELECT id, name FROM country WHERE version = ? and slug = ?', array($this->version, $slug));
		$results = $query->result();
		if( count($results) > 0 ){
			return $results[0];
		}
		return null;
	}

	public function getRegions(){
		$query = $this->db->query('SELECT id, name, slug FROM region WHERE version = ? ORDER BY name', array($this->version));
		return $query->result();
	}

	public function getCountriesByRegionId( $id ){
		$query = $this->db->query('SELECT c.id, c.name, c.slug, (SELECT COUNT(*) FROM countryorganization co WHERE co.version = c.version AND co.countryid = c.id) AS orgcount FROM country c WHERE c.version = ? AND c.regionid =  ? ORDER BY name', array($this->version, $id));
		return $query->result();
	}

	public function getCountriesByRegions(){
		$regions = $this->getRegions();
		foreach ($regions as $region) {
			$region->countries = $this->getCountriesByRegionId( $region->id );
		}
		return $regions;
	}

	public function getCountryBySlugWithOrganizations( $slug ){
		$country = $this->getCountryBySlug( $slug );
		if( $country != null ){
			$country->orgs = $this->getOrganizationsByCountryId( $country->id );
		}
		return $country;
	}

	public function getMyCharities(){
		return array();
	}

	public function emailExists($email){
		return count($this->db->query('SELECT id FROM user WHERE email = ?', array($email))->result()) > 0;
	}

	public function register($name, $email, $password){
		$this->db->query('INSERT INTO user(created,updated, email,password,name) VALUES (NOW(),NOW(), ?,?,?)', 
			array( 
				$email, 
				$this->encrypt($password), 
				$name 
			) 
		);
		return true;
	}

	public function authenticate($email, $password){
		$query = $this->db->query('SELECT id, email, name, password FROM user WHERE email = ?', array($email));
		$results = $query->result();
		if( count($results) > 0 ){
			if( $this->decrypt($results[0]->password) === $password ){
				unset($results[0]->password);
			}
			return $results[0];
		}
		return null;
	}

	public function getUserByEmail($email){

		$query = $this->db->query('SELECT id, email, name, password FROM user WHERE email = ? LIMIT 1', array($email));
		$results = $query->result();
		if( count($results) > 0 ){
			return $results[0];
		}
		return null;
	}

	public function getOrganizationsByUserId( $userid ){
		$sqlStmt = 'SELECT o.id, o.name, o.slug ';
		$sqlStmt .= 'FROM mycharity mc ';
		$sqlStmt .= 'INNER JOIN organization o ON o.version = ? AND o.id = mc.organizationid ';
		$sqlStmt .= 'WHERE mc.userid = ? ';
		$sqlStmt .= 'ORDER BY o.name ASC ';

		$query = $this->db->query($sqlStmt, array($this->version, $userid) );
		return $query->result();
	}

	const CRYPT_SALT = 85;
	const START_CHAR_CODE = 100;

	function encrypt_symbol($c) {
		# $c is ASCII code of symbol. returns 2-letter text-encoded version of symbol
		return chr(self::START_CHAR_CODE + ($c & 240) / 16).chr(self::START_CHAR_CODE + ($c & 15));
	}
	
	function encrypt($text) {
	    if (strlen($text) === 0){
	        return $text;
	    }

	    $salt = rand(1,255); # generate random salt.
	    $result = $this->encrypt_symbol($salt); # include salt in the result;
	    $salt ^= self::CRYPT_SALT;
	    for ($i = 0; $i < strlen($text); $i++) {
	        $r = ord(substr($text, $i, 1)) ^ $salt++;
	        if ($salt > 255){
	            $salt = 0;
	        }
	        $result .= $this->encrypt_symbol($r);
	    }
	    return $result;
	}
	
	function decrypt_symbol($s, $i) {
		# $s is a text-encoded string, $i is index of 2-char code. function returns number in range 0-255
		return (ord(substr($s, $i, 1)) - self::START_CHAR_CODE)*16 + ord(substr($s, $i+1, 1)) - self::START_CHAR_CODE;
	}
	
	function decrypt($cypher) {
	    if (strlen($cypher) === 0){
	        return $cypher;
	    }
		$result = '';
	    $enc = self::CRYPT_SALT ^ $this->decrypt_symbol($cypher, 0);
	    for ($i = 2; $i < strlen($cypher); $i+=2) { # $i=2 to skip salt
	        $result .= chr($this->decrypt_symbol($cypher, $i) ^ $enc++);
	        if ($enc > 255)
	            $enc = 0;
	    }
	    return $result;
	}

}

