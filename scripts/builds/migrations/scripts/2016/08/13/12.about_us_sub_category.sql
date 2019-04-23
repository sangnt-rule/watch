CREATE TABLE about_us_sub_category
(
  about_us_sub_category_id int(11) unsigned not null auto_increment,
  about_us_sub_category_name varchar(200) not null,
  about_us_sub_category_content text default null,
  about_us_sub_category_priority int(11) unsigned not null,
  about_us_sub_category_original int(11) unsigned default null comment 'Thong tin goc',
  about_us_sub_category_created_at datetime not null,
  about_us_sub_category_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  fk_about_us_category int(11) unsigned not null,
  primary key (about_us_sub_category_id),
  constraint `fk_about_us_sub_category_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_about_us_sub_category_about_us_category` foreign key (fk_about_us_category) references about_us_category(about_us_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Danh muc cap 2 - Gioi Thieu';