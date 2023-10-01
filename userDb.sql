CREATE TABLE tbl_user (
  user_id int(8) unsigned NOT NULL auto_increment, 
  first_name varchar(180) NOT NULL default '',
  last_name varchar(180) NOT NULL default '',
  user_name varchar(180) NOT NULL default '',
  password varchar(180) NOT NULL default '',
  profile_picture varchar(255) default NULL, 
  PRIMARY KEY  (user_id)
);

CREATE TABLE tbl_posts (
  post_id int(8) unsigned NOT NULL auto_increment,
  user_id int(8) unsigned NOT NULL,
  post_content text NOT NULL,
  post_image varchar(255) default NULL, 
  post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY  (post_id),
  FOREIGN KEY (user_id) REFERENCES tbl_user(user_id)
);
