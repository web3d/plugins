
CREATE TABLE IF NOT EXISTS `table.alumni_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `class_num` int(11) DEFAULT '0',
  `parent_id` int(11) DEFAULT '0',
  PRIMARY KEY (`DeptID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `table.alumni_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `stud_count` smallint(6) DEFAULT '1',
  `pwd` varchar(20) DEFAULT NULL,
  `enrollment_year` smallint(6) NOT NULL,
  `reg_date` datetime NOT NULL,
  `visit_count` int(11) DEFAULT '0',
  `homepage` varchar(50) DEFAULT NULL,
  `creator` varchar(30) NOT NULL,
  `pronouncement` varchar(255) DEFAULT NULL,
  `open_level` tinyint(3) unsigned DEFAULT '0',
  `is_contact_show` tinyint(1) DEFAULT '0',
  `admin1` varchar(50) DEFAULT NULL,
  `admin2` varchar(50) DEFAULT NULL,
  `rights` varchar(100) NOT NULL DEFAULT '11010010110000000011001000010000001',
  `dept_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `dept_id` (`dept_id`),
  KEY `enrollment_year` (`enrollment_year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `table.alumni_class_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `collector` varchar(20) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `zip_code` varchar(6) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `mobile_phone` varchar(30) DEFAULT NULL,
  `home_tel` varchar(15) DEFAULT NULL,
  `office_tel` varchar(15) DEFAULT NULL,
  `workshop` varchar(100) DEFAULT NULL,
  KEY `appendclassid` (`class_id`),
  KEY `name` (`name`),
  PRIMARY KEY `Auto_Increment_Key` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `table.alumni_class_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `mgr_date` datetime NOT NULL,
  `class_id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `is_sys_admin` tinyint(1) DEFAULT '0',
  KEY `classid` (`class_id`),
  KEY `Loguserid` (`uid`),
  KEY `Auto_Increment_Key` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `table.alumni_class_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT '0',
  `name` varchar(30) DEFAULT NULL,
  `remark` varchar(250) DEFAULT NULL,
  `visit_count` int(11) DEFAULT '0',
  `class_id` int(11) DEFAULT '0',
  `title` varchar(30) DEFAULT NULL,
  `width` int(11) DEFAULT '0',
  `height` int(11) DEFAULT '0',
  `format` varchar(10) DEFAULT NULL,
  `depth` int(11) DEFAULT '0',
  `uptime` datetime DEFAULT NULL,
  `passed` tinyint(1) DEFAULT NULL,
  `type_id` tinyint(3) unsigned DEFAULT '0',
  UNIQUE KEY `photopicid` (`id`),
  KEY `classid` (`class_id`),
  KEY `name` (`name`),
  KEY `Passed` (`passed`),
  KEY `typeid` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `table.alumni_class_photo_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `content` varchar(255) NOT NULL,
  `sign_date` datetime DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `commentpicID` (`pic_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `table.alumni_class_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `content` text,
  `uid` int(11) NOT NULL DEFAULT '0',
  `class_id` int(11) DEFAULT '0',
  `ip` varchar(20) DEFAULT NULL,
  `mood` tinyint(3) unsigned DEFAULT '0',
  `sign_time` datetime DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `classid` (`class_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `table.alumni_user_profile` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `realname` varchar(10) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `homepage` varchar(50) DEFAULT NULL,
  `visit_count` int(11) DEFAULT '1',
  `reg_date` datetime DEFAULT NULL,
  `zip_code` varchar(6) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `oicq` varchar(15) DEFAULT NULL,
  `maxim` varchar(255) DEFAULT NULL,
  `point` int(11) DEFAULT '0',
  `msn` varchar(30) DEFAULT NULL,
  `is_email_show` tinyint(1) DEFAULT '0',
  `is_oicq_show` tinyint(1) DEFAULT '0',
  `ish_omepage_show` tinyint(1) DEFAULT '0',
  `is_msn_show` tinyint(1) DEFAULT '0',
  `workshop` varchar(100) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `class_count` tinyint(3) unsigned DEFAULT '0',
  `mobile_phone` varchar(30) DEFAULT NULL,
  `wish` varchar(250) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `image_id` smallint(6) DEFAULT '0',
  `home_tel` varchar(15) DEFAULT NULL,
  `office_tel` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `table.alumni_user_class` (
  `uid` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `visit_count` int(11) DEFAULT '0',
  `join_time` datetime DEFAULT NULL,
  `last_visit` datetime DEFAULT NULL,
  `degree` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_auditing` tinyint(1) DEFAULT '0',
  KEY `isauditing` (`is_auditing`),
  KEY `joinclassclassid` (`class_id`),
  KEY `joinclassuserid` (`uid`),
  KEY `jointime` (`join_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `table.alumni_user_friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `redun_username` varchar(32) NOT NULL,
  `friend_uid` int(11) DEFAULT '0',
  `redun_friend_username` varchar(32) NOT NULL,
  `add_time` datetime DEFAULT NULL,
  KEY `uid` (`uid`),
  KEY `Auto_Increment_Key` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `table.alumni_user_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(50) NOT NULL,
  `incept` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `content` longtext,
  `flag` smallint(6) DEFAULT '0',
  `send_time` datetime NOT NULL,
  `delR` int(11) DEFAULT '0',
  `delS` int(11) DEFAULT '0',
  `is_send` int(11) DEFAULT '0',
  KEY `sender` (`sender`),
  KEY `Auto_Increment_Key` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `table.alumni_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `collector` varchar(30) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `mobile_phone` varchar(30) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `home_tel` varchar(15) DEFAULT NULL,
  `office_tel` varchar(15) DEFAULT NULL,
  `qq` varchar(15) DEFAULT NULL,
  `is_audit` tinyint(1) DEFAULT '0',
  KEY `name` (`name`),
  KEY `Auto_Increment_Key` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `table.alumni_user_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `login_time` datetime NOT NULL,
  `active_time` datetime NOT NULL,
  `location` varchar(120) DEFAULT NULL,
  `act` varchar(50) DEFAULT NULL,
  KEY `onlineuserid` (`userid`),
  PRIMARY KEY `Auto_Increment_Key` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
