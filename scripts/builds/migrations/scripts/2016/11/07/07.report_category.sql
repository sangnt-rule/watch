CREATE TABLE report_category
(
  report_category_id int(11) unsigned not null auto_increment,
  report_category_name varchar(200) not null,
  report_category_content text default null,
  report_category_priority int(11) unsigned not null,
  report_category_original int(11) unsigned default null comment 'Thong tin goc',
  report_category_display_homepage tinyint(1) unsigned default 1 comment 'Hien thi trang chu',
  report_category_created_at datetime not null,
  report_category_updated_at timestamp default CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (report_category_id),
  constraint `fk_report_category_id_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Danh muc Tuong thuat tran dua';