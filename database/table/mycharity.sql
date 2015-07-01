CREATE TABLE IF NOT EXISTS mycharity (

	userid 			INT(11) NOT NULL,
	organizationid	INT(11) NOT NULL,
	version 		INT(11) NOT NULL,

	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  KEY (userid),
  KEY (organizationid)

) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

