<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataModel extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function saveRegion( $dto, $version ) {

		if( $this->count( 'region', array( array( 'name' => 'name', 'value' => $dto->name ), array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){
			echo "<p>Region $dto->slug saving...</p>";

			$this->db->query('INSERT INTO region(created,updated, version,id,name,slug) VALUES (NOW(),NOW(),?,?,?,?)', 
				array( 
					$version, 
					$dto->regionid, 
					$dto->name, 
					$dto->slug ) 
			);
		} 
		else {
			echo "<p>Region $dto->slug has already being saved!</p>";
		}
		return $dto;
	}

	public function saveCountry( $dto, $version ) {
		
		if( $this->count( 'country', array( array( 'name' => 'name', 'value' => $dto->name ), array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){
			echo "<p>Country $dto->slug saving...</p>";

			$this->db->query('INSERT INTO country(created,updated, version,id,name,slug,regionid) VALUES (NOW(),NOW(),?,?,?,?,?)', 
				array( 
					$version, 
					$dto->countryid, 
					$dto->name, 
					$dto->slug,
					$dto->regionid ) 
			);
		} 
		else {
			echo "<p>Country $dto->slug has already being saved!</p>";
		}
		return $dto;
	}

	public function saveCategory( $dto, $version ) {
		
		if( $this->count( 'category', array( array( 'name' => 'name', 'value' => $dto->name ), array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){
			echo "<p>Category $dto->slug saving...</p>";

			$this->db->query('INSERT INTO category(created,updated, version,id,name,slug,description) VALUES (NOW(),NOW(),?,?,?,?,?)', 
				array( 
					$version, 
					$dto->categoryid, 
					$dto->name, 
					$dto->slug,
					$dto->description ) 
			);
		} 
		else {
			echo "<p>Category $dto->slug has already being saved!</p>";
		}
		return $dto;
	}

	public function saveCause( $dto, $version ) {
		
		if( $this->count( 'cause', array( array( 'name' => 'name', 'value' => $dto->name ), array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){
			echo "<p>Cause $dto->slug saving...</p>";

			$this->db->query('INSERT INTO cause(created,updated, version,id,name,slug,description,categoryid) VALUES (NOW(),NOW(),?,?,?,?,?,?)', 
				array( 
					$version, 
					$dto->causeid, 
					$dto->name, 
					$dto->slug,
					$dto->description,
					$dto->categoryid) 
			);
		} 
		else {
			echo "<p>Cause $dto->slug has already being saved!</p>";
		}
		return $dto;
	}

	public function count( $table, $columns ){
		foreach ($columns as $column) {
			$this->db->where( $column['name'], $column['value'] );
		}
		$this->db->from( $table );
		return $this->db->count_all_results();
	}

	public function saveCelebrityType( $dto, $version ) {
		
		if( $this->count( 'celebritytype', array( array( 'name' => 'name', 'value' => $dto->name ), array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){
			echo "<p>CelebrityType $dto->slug saving...</p>";

			$this->db->query('INSERT INTO celebritytype(created,updated, version,id,name,slug) VALUES (NOW(),NOW(),?,?,?,?)', 
				array( 
					$version, 
					$dto->typeid, 
					$dto->name, 
					$dto->slug ) 
			);
		} 
		else {
			echo "<p>CelebrityType $dto->slug has already being saved!</p>";
		}
		return $dto;
	}

	public function saveCelebrity( $dto, $version ) {
		
		if( $this->count( 'celebrity', array( array( 'name' => 'name', 'value' => $dto->name ), array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){
			echo "<p>Celebrity $dto->slug saving...</p>";

			$this->db->query('INSERT INTO celebrity(created,updated, version,id,name,slug,celebritytypeid,orgcount) VALUES (NOW(),NOW(),?,?,?,?,?,?)', 
				array( 
					$version, 
					$dto->celebrityid, 
					$dto->name, 
					$dto->slug,
					$dto->celebrityTypeRef->typeid,
					$dto->charity_count ) 
			);
		} 
		else {
			echo "<p>Celebrity $dto->slug has already being saved!</p>";
		}
		return $dto;
	}

	public function saveCelebrityRelationship( $dto, $version ) {
		
		if( $this->count( 'celebrityrelationship', array( array( 'name' => 'name', 'value' => $dto->name ), array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){
			echo "<p>Celebrity Relationship $dto->slug saving...</p>";

			$this->db->query('INSERT INTO celebrityrelationship(created,updated, version,id,name,slug) VALUES (NOW(),NOW(),?,?,?,?)', 
				array( 
					$version, 
					$dto->relationshipid, 
					$dto->name, 
					$dto->slug ) 
			);
		} 
		else {
			echo "<p>Celebrity Relationship $dto->slug has already being saved!</p>";
		}
		return $dto;
	}

	public function saveList( $dto, $version ) {
		
		if( $this->count( 'list', array( array( 'name' => 'name', 'value' => $dto->name ), array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){
			echo "<p>List $dto->slug saving...</p>";

			$this->db->query('INSERT INTO list(created,updated, version,id,name,slug,type,description,sort) VALUES (NOW(),NOW(),?,?,?,?,?,?,?)', 
				array( 
					$version, 
					$dto->listid, 
					$dto->name, 
					$dto->slug,
					$dto->list_type,
					$dto->description,
					$dto->sort ) 
			);
		} 
		else {
			echo "<p>List $dto->slug has already being saved!</p>";
		}
		return $dto;
	}

	public function saveListOrganization( $dto, $version ) {
		
		if( $this->count( 'listorganization', array( 
			array( 'name' => 'listid', 'value' => $dto->listRef->listid ), 
			array( 'name' => 'organizationid', 'value' => $dto->organizationRef->orgid ),
			array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){

			echo "<p>List Organization ".$dto->listRef->slug." | ".$dto->organizationRef->slug." saving...</p>";

			$this->db->query('INSERT INTO listorganization(created,updated, version,listid,organizationid, rank,value_label,value) VALUES (NOW(),NOW(),?,?,?,?,?,?)', 
				array( 
					$version, 
					$dto->listRef->listid, 
					$dto->organizationRef->orgid, 
					$dto->rank,
					$dto->value_label,
					$dto->value ) 
			);
		} 
		else {
			echo "<p>List Organization ".$dto->listRef->slug." | ".$dto->organizationRef->slug." has already being saved!</p>";
		}
		return $dto;
	}

	public function saveCelebrityOrganization( $dto, $version ) {
		
		if( $this->count( 'celebrityorganization', array( 
			array( 'name' => 'celebrityid', 'value' => $dto->celebrityRef->celebrityid ), 
			array( 'name' => 'organizationid', 'value' => $dto->organizationRef->orgid ),
			array( 'name' => 'relationshipid', 'value' => $dto->celebrityRelationshipRef->relationshipid ),
			array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){

			echo "<p>Celebrity Organization ".$dto->celebrityRef->slug." | ".$dto->organizationRef->slug." | ".$dto->celebrityRelationshipRef->slug." saving...</p>";

			$this->db->query('INSERT INTO celebrityorganization(created,updated, version,celebrityid,organizationid, relationshipid) VALUES (NOW(),NOW(),?,?,?,?)', 
				array( 
					$version, 
					$dto->celebrityRef->celebrityid, 
					$dto->organizationRef->orgid, 
					$dto->celebrityRelationshipRef->relationshipid ) 
			);
		} 
		else {
			echo "<p>Celebrity Organization ".$dto->celebrityRef->slug." | ".$dto->organizationRef->slug." | ".$dto->celebrityRelationshipRef->slug." has already being saved!</p>";
		}
		return $dto;
	}

	public function saveCountryOrganization( $dto, $version ) {
		
		if( $this->count( 'countryorganization', array( 
			array( 'name' => 'countryid', 'value' => $dto->countryRef->countryid ), 
			array( 'name' => 'organizationid', 'value' => $dto->organizationRef->orgid ),
			array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){

			echo "<p>Country Organization ".$dto->countryRef->slug." | ".$dto->organizationRef->slug." saving...</p>";

			$this->db->query('INSERT INTO countryorganization(created,updated, version,countryid,organizationid) VALUES (NOW(),NOW(), ?,?,?)', 
				array( 
					$version, 
					$dto->countryRef->countryid, 
					$dto->organizationRef->orgid ) 
			);
		} 
		else {
			echo "<p>Country Organization ".$dto->countryRef->slug." | ".$dto->organizationRef->slug." has already being saved!</p>";
		}
		return $dto;
	}

	public function saveOrganization( $dto, $version ) {
		
		if( $this->count( 'organization', array( 
			array( 'name' => 'id', 'value' => $dto->orgid ), 
			array( 'name' => 'version', 'value' => $version ) ) ) === 0 ){

			echo "<p>Organization ".$dto->slug." saving...</p>";

			$fields = array(
				'created',
				'updated',
				'version',                  
				'id',                         
				'name',                       
				'slug', 						
				'categoryid',                 
				'causeid',                    
				'ein',                        
				'tag_line',					
				'fundraising_efficiency',		
				'fundraising_expenses_ratio',	
				'program_expenses_ratio',		
				'administration_expenses_ratio',
				'primary_revenue_growth',		
				'program_expenses_growth',		
				'working_capital_ratio',		
				'mission',						
				'street_address_1',			
				'street_address_2',			
				'city',  						
				'state',						
				'zip', 						
				'cob_name',					
				'cob_title',					
				'current_ceo_name',			
				'current_ceo_title',			
				'financial_score',				
				'financial_rating',			
				'accountability_score',		
				'accountability_rating',		
				'overall_score',				
				'overall_rating',				
				'fundraising_expenses', 		
				'administration_expenses', 	
				'program_expenses', 			
				'total_expenses',				
				'total_revenue',				
				'total_net_assets',			
				'boardlist_status',			
				'stafflist_status',			
				'auditedfinancial_status', 	
				'form990_status',				
				'privacy_status',				
				'loanstoorfromofficers',		
				'loanstoofficers', 			
				'materialdiversionofassets', 	
				'boardmeetingminutes', 		
				'distributes990toboard', 		
				'conflictofinterestpolicy',	
				'whistleblowerpolicy', 		
				'recordsretentionpolicy', 		
				'reportsceoandsalary', 		
				'ceocompensationprocedure',	
				'compensatesboard', 			
				'independentaudit', 			
				'boardcomposition'
			);
			
			$placeholders = array();
			$values = array();
			$flag = 'off';

			foreach($fields as $field){

				if( $flag === 'off' ){

					if( $field === 'created' || $field === 'updated' ){
						$placeholders[] = 'NOW()';
					}
					if( $field === 'version' ){
						$placeholders[] = '?';	
						$values[] = $version;
					}
					if( $field === 'id' ){
						$placeholders[] = '?';	
						$values[] = $dto->orgid;
					}
					if( $field === 'name' || $field === 'slug' ){
						$placeholders[] = '?';
						$values[] = $dto->{$field};
					}
					if( $field === 'categoryid' ){
						$placeholders[] = '?';
						$values[] = $dto->categoryRef->categoryid;
					}
					if( $field === 'causeid' ){
						$placeholders[] = '?';
						$values[] = $dto->causeRef->causeid;
						$flag = 'on';
					}
				}
				else {

					$placeholders[] = '?';
					$values[] = $dto->{$field};
				}
			}

			$sqlStmt = 'INSERT INTO organization('.implode(',', $fields).') VALUES ('.implode(',', $placeholders).')';

			echo '<code>'.$sqlStmt.'</code>';

			$this->db->query($sqlStmt, $values );
		} 
		else {
			echo "<p>Organization ".$dto->slug." has already being saved!</p>";
		}
		return $dto;
	}
}

