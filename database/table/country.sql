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

