CREATE TABLE club
(
club_id int(11) unsigned not null auto_increment,
club_title varchar(200) not null,
club_sub_content text default null,
club_content text not null,
club_image varchar(100) not null,
club_file varchar(100) default null,
club_date date default null,
club_sponsor tinyint(1) not null default 0 comment 'Sponsor',
club_original int(11) unsigned default null comment 'Thong tin goc',
club_created_at datetime not null,
club_updated_at timestamp DEFAULT CURRENT_TIMESTAMP on update current_timestamp,
fk_club_category int(11) unsigned not null,
fk_locale tinyint(4) unsigned default 1 not null,
fk_config_active tinyint(4) unsigned default 1 not null,
primary key (club_id),
constraint `fk_club_id_locale` foreign key (fk_locale) references locale(locale_id),
constraint `fk_club_club_category` foreign key (fk_club_category) references club_category(club_category_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Cau Lac Bo';