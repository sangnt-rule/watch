CREATE TABLE member
(
member_id int(11) unsigned not null auto_increment,
member_title varchar(200) not null,
member_sub_content text default null,
member_content text not null,
member_image varchar(100) not null,
member_file varchar(100) default null,
member_date date default null,
member_sponsor tinyint(1) not null default 0 comment 'Sponsor',
member_original int(11) unsigned default null comment 'Thong tin goc',
member_created_at datetime not null,
member_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
fk_member_category int(11) unsigned not null,
fk_locale tinyint(4) unsigned default 1 not null,
fk_config_active tinyint(4) unsigned default 1 not null,
primary key (member_id),
constraint `fk_member_id_locale` foreign key (fk_locale) references locale(locale_id),
constraint `fk_member_member_category` foreign key (fk_member_category) references member_category(member_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Thanh Vien';