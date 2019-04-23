CREATE TABLE booking
(
  booking_id int(11) unsigned not null auto_increment,
  booking_full_name varchar(100) not null,
  booking_email varchar(100) not null,
  booking_phone varchar(20) not null,
  booking_address varchar(200) not null,
  booking_note varchar(200) default null,
  booking_pic int(11) unsigned default null,
  booking_created_at datetime not null,
  booking_updated_at timestamp on update current_timestamp,
  fk_booking_status tinyint(4) unsigned not null,
  primary key (booking_id),
  constraint `booking_pic` foreign key (booking_pic) references admin(admin_id),
  constraint `fk_booking_booking_status` foreign key (fk_booking_status) references booking_status(booking_status_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Booking';