CREATE TABLE faq_category
(
  faq_category_id int(11) unsigned not null auto_increment,
  faq_category_name varchar(200) not null,
  faq_category_priority int(11) unsigned not null,
  faq_category_original int(11) unsigned default null comment 'Thong tin goc',
  faq_category_display_homepage tinyint(1) unsigned default 1 comment 'Hien thi trang chu',
  faq_category_created_at datetime not null,
  faq_category_updated_at timestamp on update current_timestamp,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (faq_category_id),
  constraint `fk_faq_category_id_locale` foreign key (fk_locale) references locale(locale_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Danh muc FAQ';