CREATE TABLE faq
(
  faq_id int(11) unsigned not null auto_increment,
  faq_question varchar(200) not null,
  faq_answer text not null,
  faq_priority int(11) unsigned default 0 not null,
  faq_original int(11) unsigned default null comment 'Thong tin goc',
  faq_created_at datetime not null,
  faq_updated_at timestamp on update current_timestamp,
  fk_faq_category int(11) unsigned not null,
  fk_locale tinyint(4) unsigned default 1 not null,
  fk_config_active tinyint(4) unsigned default 1 not null,
  primary key (faq_id),
  constraint `fk_faq_id_locale` foreign key (fk_locale) references locale(locale_id),
  constraint `fk_faq_faq_category` foreign key (fk_faq_category) references faq_category(faq_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'FAQ';