CREATE TABLE horse
(
  horse_id int(11) unsigned not null auto_increment,
  horse_name varchar(100) not null,
  horse_owner varchar(100) not null,
  horse_content text default null comment 'Thanh tich',
  horse_kind varchar(200) not null comment 'Giong',
  horse_color varchar(200) not null comment 'Mau sac',
  horse_from varchar(200) not null comment 'Xuat xu',
  horse_height varchar(200) not null comment 'Chieu cao',
  horse_age varchar(200) not null comment 'Tuoi',
  horse_priority int(11) unsigned not null,
  horse_original int(11) unsigned default null comment 'Thong tin goc',
  horse_created_at datetime not null,
  horse_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_horse_type tinyint(4) unsigned default 1 not null,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (horse_id),
  constraint `fk_horse_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_horse_horse_type` foreign key (fk_horse_type) references horse_type(horse_type_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Thanh tich ngua dua';