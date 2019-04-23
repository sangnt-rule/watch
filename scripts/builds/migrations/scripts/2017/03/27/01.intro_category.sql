CREATE TABLE intro_category
(
  intro_category_id int(11) unsigned not null auto_increment,
  intro_category_name varchar(200) not null,
  intro_category_image varchar(100) default null,
  intro_category_sub_content text default null,
  intro_category_content text default null,
  intro_category_priority int(11) unsigned not null,
  intro_category_original int(11) unsigned default null comment 'Thong tin goc',
  intro_category_created_at datetime not null,
  intro_category_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (intro_category_id),
  constraint `fk_intro_category_id_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Gioi thieu';