CREATE TABLE IF NOT EXISTS user (

	id 			INT(11) NOT NULL AUTO_INCREMENT,
	email		VARCHAR(64) NOT NULL,
	password	VARCHAR(256) NOT NULL,
	name		VARCHAR(64) NOT NULL,
	
	created			DATETIME NOT NULL,
	updated 		DATETIME NOT NULL,

  PRIMARY KEY (email),
  KEY (id)

) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO user (email, password, name, created, updated) VALUES( 'miguel@miguelmartinez.com','SHYTUeG+GHC9WmavUTG9W41r0EdfMoWPIZj5HFBtTfVtSE+BtgTqStB/yvgIvcqVItTK+RZR+gMqzrjBQ9Sr3g==', 'Miguel', NOW(), NOW() );

