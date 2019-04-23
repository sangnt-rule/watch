CREATE TABLE slider_souvenir
(
  slider_souvenir_id int(11) unsigned not null auto_increment,
  slider_souvenir_title varchar(200) not null,
  slider_souvenir_image varchar(100) not null,
  slider_souvenir_url varchar(100) default null,
  slider_souvenir_content varchar(300) default null,
  slider_souvenir_priority int(11) unsigned not null,
  slider_souvenir_original int(11) unsigned default null comment 'Thong tin goc',
  slider_souvenir_created_at datetime not null,
  slider_souvenir_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (slider_souvenir_id),
  constraint `fk_slider_souvenir_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Slider qua tang trang chu';