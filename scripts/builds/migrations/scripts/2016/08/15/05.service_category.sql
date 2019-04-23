CREATE TABLE service_category
(
  service_category_id int(11) unsigned not null auto_increment,
  service_category_name varchar(200) not null,
  service_category_content text not null,
  service_category_priority int(11) unsigned not null,
  service_category_original int(11) unsigned default null comment 'Thong tin goc',
  service_category_created_at datetime not null,
  service_category_updated_at timestamp on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (service_category_id),
  constraint `fk_service_category_category_id_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Danh muc cap 1 - Dich vu & Tien ich';