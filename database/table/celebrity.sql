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

