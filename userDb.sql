CREATE TABLE tbl_user (
  user_id int(8) unsigned NOT NULL auto_increment, 
  first_name varchar(180) NOT NULL default '',
  last_name varchar(180) NOT NULL default '',
  user_name varchar(180) NOT NULL default '',
  password varchar(180) NOT NULL default '',
  profile_picture varchar(255) default NULL,
  is_seller tinyint(1) NOT NULL DEFAULT 0, -- 0 for not a seller, 1 for a seller
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

CREATE TABLE tbl_reactions (
  reaction_id int(8) unsigned NOT NULL auto_increment,
  post_id int(8) unsigned NOT NULL,
  user_id int(8) unsigned NOT NULL,
  reaction_type varchar(20) NOT NULL,
  PRIMARY KEY (reaction_id),
  FOREIGN KEY (post_id) REFERENCES tbl_posts(post_id),
  FOREIGN KEY (user_id) REFERENCES tbl_user(user_id)
);

CREATE TABLE tbl_comments (
  comment_id int(8) unsigned NOT NULL auto_increment,
  post_id int(8) unsigned NOT NULL,
  user_id int(8) unsigned NOT NULL,
  comment_content text NOT NULL,
  comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (comment_id),
  FOREIGN KEY (post_id) REFERENCES tbl_posts(post_id),
  FOREIGN KEY (user_id) REFERENCES tbl_user(user_id)
);

CREATE TABLE tbl_categories (
  category_id int(8) unsigned NOT NULL auto_increment,
  category_name varchar(255) NOT NULL,
  PRIMARY KEY (category_id)
);

CREATE TABLE tbl_products (
  product_id int(8) unsigned NOT NULL auto_increment,
  category_id int(8) unsigned NOT NULL,
  seller_id int(8) unsigned NOT NULL,
  product_name varchar(255) NOT NULL,
  product_description text NOT NULL,
  product_image varchar(255) default NULL,
  price decimal(10,2) NOT NULL,
  PRIMARY KEY (product_id),
  FOREIGN KEY (category_id) REFERENCES tbl_categories(category_id),
  FOREIGN KEY (seller_id) REFERENCES tbl_user(user_id)
);

CREATE TABLE tbl_cart (
  cart_id int(8) unsigned NOT NULL auto_increment,
  user_id int(8) unsigned NOT NULL,
  product_id int(8) unsigned NOT NULL,
  quantity int(5) NOT NULL DEFAULT 1,
  PRIMARY KEY (cart_id),
  FOREIGN KEY (user_id) REFERENCES tbl_user(user_id),
  FOREIGN KEY (product_id) REFERENCES tbl_products(product_id)
);
