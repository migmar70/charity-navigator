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

