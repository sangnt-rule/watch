CREATE TABLE category
(
  category_id int(11) unsigned not null auto_increment,
  category_name varchar(200) not null,
  category_active int(11) ,
  primary key (category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'the loai';