CREATE TABLE report
(
  report_id int(11) unsigned not null auto_increment,
  report_title varchar(200) not null,
  report_sub_content text default null,
  report_content text not null,
  report_image varchar(100) not null,
  report_file varchar(100) default null,
  report_date date default null,
  report_sponsor tinyint(1) not null default 0 comment 'Sponsor',
  report_original int(11) unsigned default null comment 'Thong tin goc',
  report_created_at datetime not null,
  report_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_report_category int(11) unsigned not null,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (report_id),
  constraint `fk_report_id_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_report_report_category` foreign key (fk_report_category) references report_category(report_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Tuong thuat';