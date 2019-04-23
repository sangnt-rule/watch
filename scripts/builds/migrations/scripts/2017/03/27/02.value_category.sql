CREATE TABLE value_category
(
  value_category_id int(11) unsigned not null auto_increment,
  value_category_name varchar(200) not null,
  value_category_image varchar(100) default null,
  value_category_sub_content text default null,
  value_category_content text default null,
  value_category_priority int(11) unsigned not null,
  value_category_original int(11) unsigned default null comment 'Thong tin goc',
  value_category_created_at datetime not null,
  value_category_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (value_category_id),
  constraint `fk_value_category_id_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Gioi thieu';