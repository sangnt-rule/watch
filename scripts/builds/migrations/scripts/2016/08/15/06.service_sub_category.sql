CREATE TABLE service_sub_category
(
  service_sub_category_id int(11) unsigned not null auto_increment,
  service_sub_category_name varchar(200) not null,
  service_sub_category_content text not null,
  service_sub_category_priority int(11) unsigned not null,
  service_sub_category_original int(11) unsigned default null comment 'Thong tin goc',
  service_sub_category_created_at datetime not null,
  service_sub_category_updated_at timestamp on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  fk_service_category int(11) unsigned not null,
  primary key (service_sub_category_id),
  constraint `fk_service_sub_category_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_service_sub_category_service_category` foreign key (fk_service_category) references service_category(service_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Danh muc cap 2 - Dich vu & Tien ich';