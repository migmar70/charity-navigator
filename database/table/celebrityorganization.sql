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

