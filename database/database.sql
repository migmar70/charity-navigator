CREATE TABLE IF NOT EXISTS category (
	
	version 		INT(11) NOT NULL,
	id 				INT(11) NOT NULL,
	name 			VARCHAR(32) NOT NULL,
	slug 			VARCHAR(32) NOT NULL,

	description 	TEXT NOT NULL,

	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  PRIMARY KEY (version,id),
  UNIQUE KEY (version,name),
  UNIQUE KEY (version,slug)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS cause (

	version 		INT(11) NOT NULL,
	id 				INT(11) NOT NULL,
	name 			VARCHAR(64) NOT NULL,
	description 	TEXT NOT NULL,
	slug 			VARCHAR(64) NOT NULL,

	categoryid		INT(11) NOT NULL,

	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  PRIMARY KEY (version,id),
  UNIQUE KEY (version,name),
  UNIQUE KEY (version,slug),
  KEY (version,categoryid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS celebrity (

	version 		INT(11) NOT NULL,
	id 				INT(11) NOT NULL,
	name 			VARCHAR(128) NOT NULL,
	slug 			VARCHAR(128) NOT NULL,
	
	celebritytypeid	INT(11) NOT NULL,

	orgcount		INT(11) NOT NULL,

	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  PRIMARY KEY (version,id),
  UNIQUE KEY (version,name),
  UNIQUE KEY (version,slug),
  KEY (version,celebritytypeid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS celebrityorganization (

	version 		INT(11) NOT NULL,
	celebrityid 	INT(11) NOT NULL,
	organizationid 	INT(11) NOT NULL,
	relationshipid 	INT(11) NOT NULL,

	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  	PRIMARY KEY (version,celebrityid,organizationid,relationshipid),

   	KEY (version,celebrityid),
	KEY (version,organizationid),
	KEY (version,relationshipid)
	
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS celebrityrelationship (

	version 		INT(11) NOT NULL,
	id 				INT(11) NOT NULL,
	name 			VARCHAR(32) NOT NULL,
	slug 			VARCHAR(32) NOT NULL,

	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  PRIMARY KEY (version,id),
  UNIQUE KEY (version,name),
  UNIQUE KEY (version,slug)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS celebritytype (

	version 		INT(11) NOT NULL,
	id 				INT(11) NOT NULL,
	name 			VARCHAR(32) NOT NULL,
	slug 			VARCHAR(32) NOT NULL,

	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  PRIMARY KEY (version,id),
  UNIQUE KEY (version,name),
  UNIQUE KEY (version,slug)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS country (

	version 		INT(11) NOT NULL,
	id 				INT(11) NOT NULL, -- countryid
	name 			VARCHAR(32) NOT NULL,

	regionid 		INT(11) NOT NULL,

	slug 			VARCHAR(32) NOT NULL,

	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  PRIMARY KEY (version,id),
  UNIQUE KEY (version,name),
  UNIQUE KEY (version,slug),
  KEY (version,regionid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS countryorganization (

  version         INT(11) NOT NULL,
  countryid       INT(11) NOT NULL,
  organizationid  INT(11) NOT NULL,

  created     DATETIME NOT NULL,
  updated     DATETIME NOT NULL,

  PRIMARY KEY (version,countryid,organizationid),

  KEY (version,countryid),
  KEY (version,organizationid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS list (

	version 		INT(11) NOT NULL,
	id 				INT(11) NOT NULL, -- listid
	name 			VARCHAR(128) NOT NULL,
	slug 			VARCHAR(128) NOT NULL,
	type 			VARCHAR(64) NOT NULL,
	description 	TEXT NOT NULL,

	sort 			VARCHAR(4) NULL,
	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  PRIMARY KEY (version,id),
  UNIQUE KEY (version,name),
  UNIQUE KEY (version,slug),
  INDEX (version,type)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS listorganization (

  version         INT(11) NOT NULL,
  listid          INT(11) NOT NULL,  
  organizationid  INT(11) NOT NULL,  

  rank            INT(11) NOT NULL,
  value_label     VARCHAR(32) NOT NULL,
  value           VARCHAR(32) NOT NULL,

  created       DATETIME NOT NULL,
  updated       DATETIME NOT NULL,
  
  PRIMARY KEY (version,listid,organizationid),

  KEY (version,listid),
  KEY (version,organizationid)

) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS organization (

    version                         INT(11) NOT NULL,
    id                              INT(11) NOT NULL,
    name                            VARCHAR(128) NOT NULL,
	slug 							VARCHAR(128) NOT NULL,
	categoryid                      INT(11) NOT NULL,
	causeid                         INT(11) NOT NULL,

    ein                             VARCHAR(16) NOT NULL,
	tag_line						VARCHAR(128) NOT NULL,
    fundraising_efficiency			VARCHAR(32) NOT NULL,
    fundraising_expenses_ratio		VARCHAR(32) NOT NULL,
    program_expenses_ratio			VARCHAR(32) NOT NULL,
    administration_expenses_ratio	VARCHAR(32) NOT NULL,
    primary_revenue_growth			VARCHAR(32) NOT NULL,
    program_expenses_growth			VARCHAR(32) NOT NULL,
    working_capital_ratio			VARCHAR(32) NOT NULL,

    mission							TEXT NOT NULL,

    street_address_1				VARCHAR(64) NOT NULL,
    street_address_2				VARCHAR(64) NOT NULL,
    city  							VARCHAR(64) NOT NULL,
    state							VARCHAR(64) NOT NULL,
    zip 							VARCHAR(16) NOT NULL,
			
    cob_name						VARCHAR(64) NOT NULL,
    cob_title						VARCHAR(64) NOT NULL,
    current_ceo_name				VARCHAR(64) NOT NULL,
    current_ceo_title				VARCHAR(64) NOT NULL,
	
    financial_score					VARCHAR(32) NOT NULL,
    financial_rating				VARCHAR(32) NOT NULL,
    accountability_score			VARCHAR(32) NOT NULL,
    accountability_rating			VARCHAR(32) NOT NULL,
    overall_score					VARCHAR(32) NOT NULL,
    overall_rating					VARCHAR(32) NOT NULL,
    fundraising_expenses 			VARCHAR(32) NOT NULL,
    administration_expenses 		VARCHAR(32) NOT NULL,
    program_expenses 				VARCHAR(32) NOT NULL,
    total_expenses					VARCHAR(32) NOT NULL,
    total_revenue					VARCHAR(32) NOT NULL,
    total_net_assets				VARCHAR(32) NOT NULL,
    boardlist_status				VARCHAR(32) NOT NULL,
    stafflist_status				VARCHAR(32) NOT NULL,
    auditedfinancial_status 		VARCHAR(32) NOT NULL,
    form990_status					VARCHAR(32) NOT NULL,
    privacy_status					VARCHAR(32) NOT NULL,
    loanstoorfromofficers			VARCHAR(32) NOT NULL,
    loanstoofficers 				VARCHAR(32) NOT NULL,
    materialdiversionofassets 		VARCHAR(32) NOT NULL,
    boardmeetingminutes 			VARCHAR(32) NOT NULL,
    distributes990toboard 			VARCHAR(32) NOT NULL,
    conflictofinterestpolicy		VARCHAR(32) NOT NULL,
    whistleblowerpolicy 			VARCHAR(32) NOT NULL,
    recordsretentionpolicy 			VARCHAR(32) NOT NULL,
    reportsceoandsalary 			VARCHAR(32) NOT NULL,
    ceocompensationprocedure		VARCHAR(32) NOT NULL,
    compensatesboard 				VARCHAR(32) NOT NULL,
    independentaudit 				VARCHAR(32) NOT NULL,
    boardcomposition 				VARCHAR(32) NOT NULL,

    created                         DATETIME NOT NULL,
    updated                         DATETIME NOT NULL,
  
    PRIMARY KEY (version,id),

    UNIQUE KEY (version,name),
    UNIQUE KEY (version,slug),

    KEY (version,categoryid),
    KEY (version,causeid)

) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS region (

	version 		INT(11) NOT NULL,
	id 				INT(11) NOT NULL, -- regionid
	name 			VARCHAR(32) NOT NULL,
	slug 			VARCHAR(32) NOT NULL,

	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  PRIMARY KEY (version,id),
  UNIQUE KEY (version,name),
  UNIQUE KEY (version,slug)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS version (

	version 		INT(11) NOT NULL,
	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL

) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

