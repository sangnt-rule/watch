CREATE TABLE service
(
  service_id int(11) unsigned not null auto_increment,
  service_title varchar(200) not null,
  service_sub_content text default null,
  service_content text not null,
  service_image varchar(100) not null,
  service_file varchar(100) default null,
  service_date date default null,
  service_sponsor tinyint(1) not null default 0 comment 'Sponsor',
  service_original int(11) unsigned default null comment 'Thong tin goc',
  service_created_at datetime not null,
  service_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_service_category int(11) unsigned not null,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (service_id),
  constraint `fk_service_id_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_service_service_category` foreign key (fk_service_category) references service_category(service_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Dich vu tien ich';