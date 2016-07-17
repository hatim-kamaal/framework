CREATE TABLE IF NOT EXISTS `users` (
 `id` bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `uname` varchar(250) DEFAULT "",
 `passwd` varchar(250) DEFAULT "",
 `fname` varchar(250) DEFAULT "",
 `lname` varchar(250) DEFAULT "",
 `status` boolean DEFAULT true 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `users_secret` (
 `id` bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `appname` varchar(250) DEFAULT "",
 `userid` varchar(250) DEFAULT "",
 `passwd` varchar(250) DEFAULT "",
 `desc` text,
 `uid` bigint NOT NULL ,
 FOREIGN KEY (uid) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `users_diary` (
 `id` bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `label` varchar(250) DEFAULT "",
 `desc` text,
 `dtime` timestamp DEFAULT now(),
 `uid` bigint NOT NULL,
 FOREIGN KEY (uid) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
