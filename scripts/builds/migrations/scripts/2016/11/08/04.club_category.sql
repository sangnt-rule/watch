CREATE TABLE club_category
(
  club_category_id int(11) unsigned not null auto_increment,
  club_category_name varchar(200) not null,
  club_category_content text default null,
  club_category_priority int(11) unsigned not null,
  club_category_original int(11) unsigned default null comment 'Thong tin goc',
  club_category_display_homepage tinyint(1) unsigned default 1 comment 'Hien thi trang chu',
  club_category_created_at datetime not null,
  club_category_updated_at timestamp default CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (club_category_id),
  constraint `fk_club_category_id_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Danh muc Cau Lac Bo';