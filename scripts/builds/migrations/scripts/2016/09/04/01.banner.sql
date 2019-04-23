CREATE TABLE banner
(
  banner_id int(11) unsigned not null auto_increment,
  banner_note varchar(200) not null,
  banner_image varchar(100) not null,
  banner_original int(11) unsigned default null comment 'Thong tin goc',
  banner_created_at datetime not null,
  banner_updated_at timestamp default current_timestamp on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (banner_id),
  constraint `fk_banner_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Banner cac trang con';