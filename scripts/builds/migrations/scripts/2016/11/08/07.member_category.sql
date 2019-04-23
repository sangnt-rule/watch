CREATE TABLE member_category
(
  member_category_id int(11) unsigned not null auto_increment,
  member_category_name varchar(200) not null,
  member_category_content text default null,
  member_category_priority int(11) unsigned not null,
  member_category_original int(11) unsigned default null comment 'Thong tin goc',
  member_category_display_homepage tinyint(1) unsigned default 1 comment 'Hien thi trang chu',
  member_category_created_at datetime not null,
  member_category_updated_at timestamp default CURRENT_TIMESTAMP on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (member_category_id),
  constraint `fk_member_category_id_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Danh muc Thanh Vien';