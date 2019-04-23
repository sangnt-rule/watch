CREATE TABLE content
(
  content_id int(11) unsigned not null auto_increment,
  content_title varchar(100) not null,
  content_content text default null,
  content_original int(11) unsigned default null comment 'Thong tin goc',
  content_created_at datetime not null,
  content_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (content_id),
  constraint `fk_content_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Noi dung Website';