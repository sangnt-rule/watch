CREATE TABLE recruitment
(
  recruitment_id int(11) unsigned not null auto_increment,
  recruitment_title varchar(200) not null,
  recruitment_sub_content varchar(300) not null,
  recruitment_content text not null,
  recruitment_expired_at datetime default null,
  recruitment_priority int(11) unsigned not null,
  recruitment_original int(11) unsigned default null comment 'Thong tin goc',
  recruitment_created_at datetime not null,
  recruitment_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (recruitment_id),
  constraint `fk_recruitment_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Thong tin tuyen dung';