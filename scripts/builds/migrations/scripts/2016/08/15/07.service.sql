CREATE TABLE service
(
  service_id int(11) unsigned not null auto_increment,
  service_title varchar(200) not null,
  service_sub_content text not null,
  service_content text not null,
  service_image varchar(100) not null,
  service_original int(11) unsigned default null comment 'Thong tin goc',
  service_created_at datetime not null,
  service_updated_at timestamp on update current_timestamp,
  fk_service_category int(11) unsigned not null,
  fk_service_sub_category int(11) unsigned not null,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (service_id),
  constraint `fk_service_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_service_service_sub_category` foreign key (fk_service_sub_category) references service_sub_category(service_sub_category_id),
  constraint `fk_service_service_category` foreign key (fk_service_category) references service_category(service_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Dich Vu & Tien Ich';