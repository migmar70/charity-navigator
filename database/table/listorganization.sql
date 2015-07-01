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

