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

