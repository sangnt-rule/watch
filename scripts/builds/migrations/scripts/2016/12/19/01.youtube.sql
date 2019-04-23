CREATE TABLE youtube
(
  youtube_id int(11) unsigned not null auto_increment,
  youtube_title varchar(200) not null,
  youtube_image varchar(100) not null,
  youtube_content varchar(1000) default null,
  youtube_priority int(11) unsigned not null,
  youtube_original int(11) unsigned default null comment 'Thong tin goc',
  youtube_created_at datetime not null,
  youtube_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (youtube_id),
  constraint `fk_youtube_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Slider tin tuc Youtube';