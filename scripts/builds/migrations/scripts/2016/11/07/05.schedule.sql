CREATE TABLE schedule
(
  schedule_id int(11) unsigned not null auto_increment,
  schedule_title varchar(200) not null,
  schedule_sub_content text default null,
  schedule_content text not null,
  schedule_image varchar(100) not null,
  schedule_file varchar(100) default null,
  schedule_date date default null,
  schedule_sponsor tinyint(1) not null default 0 comment 'Sponsor',
  schedule_original int(11) unsigned default null comment 'Thong tin goc',
  schedule_created_at datetime not null,
  schedule_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_schedule_category int(11) unsigned not null,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (schedule_id),
  constraint `fk_schedule_id_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_schedule_schedule_category` foreign key (fk_schedule_category) references schedule_category(schedule_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Lich Dua';