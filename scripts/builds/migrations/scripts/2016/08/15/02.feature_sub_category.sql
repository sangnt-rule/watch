CREATE TABLE feature_sub_category
(
  feature_sub_category_id int(11) unsigned not null auto_increment,
  feature_sub_category_name varchar(200) not null,
  feature_sub_category_content text not null,
  feature_sub_category_priority int(11) unsigned not null,
  feature_sub_category_original int(11) unsigned default null comment 'Thong tin goc',
  feature_sub_category_created_at datetime not null,
  feature_sub_category_updated_at timestamp on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  fk_feature_category int(11) unsigned not null,
  primary key (feature_sub_category_id),
  constraint `fk_feature_sub_category_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_feature_sub_category_feature_category` foreign key (fk_feature_category) references feature_category(feature_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Danh muc cap 2 - Diem Tham Quan';