CREATE TABLE booking_status
(
  booking_status_id tinyint(4) unsigned not null auto_increment,
  booking_status_name varchar(50) not null,
  primary key (booking_status_id)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Statuses of Booking';
Insert Into booking_status(booking_status_id, booking_status_name) values
(1, 'booking_status_init'),
(2, 'booking_status_in_process'),
(3, 'booking_status_delivered'),
(4, 'booking_status_cancellation'),
(5, 'booking_status_failed_delivery')
;