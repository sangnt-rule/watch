CREATE TABLE comment
(
  comment_id int(11) unsigned not null auto_increment,
  comment_full_name varchar(100) not null,
  comment_email varchar(100) not null,
  comment_phone varchar(40) not null,
  comment_content varchar(1000) not null,
  comment_reply text default null,
  comment_replied tinyint(1) default 0 not null,
  comment_pic int(11) unsigned default null,
  comment_created_at datetime not null,
  comment_updated_at timestamp on update current_timestamp,
  primary key (comment_id),
  constraint `fk_comment_pic` foreign key (comment_pic) references admin(admin_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Gop y khach hang';