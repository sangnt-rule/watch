CREATE TABLE slider
(
  slider_id int(11) unsigned not null auto_increment,
  slider_title varchar(200) not null,
  slider_image varchar(100) not null,
  slider_url varchar(100) default null,
  slider_content varchar(300) default null,
  slider_priority int(11) unsigned not null,
  slider_original int(11) unsigned default null comment 'Thong tin goc',
  slider_created_at datetime not null,
  slider_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (slider_id),
  constraint `fk_slider_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Slider trang chu';