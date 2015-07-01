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

