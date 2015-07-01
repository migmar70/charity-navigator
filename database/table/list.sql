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

