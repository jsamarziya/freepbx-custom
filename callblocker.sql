CREATE DATABASE `callblocker`;

CREATE TABLE `blacklist` (
  `id`          INT(11)     NOT NULL AUTO_INCREMENT,
  `cid_number`  VARCHAR(10) NOT NULL,
  `description` VARCHAR(80)          DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_blacklist_cid_number` (`cid_number`)
);

CREATE TABLE `whitelist` (
  `id`          INT(11)     NOT NULL AUTO_INCREMENT,
  `cid_number`  VARCHAR(10) NOT NULL,
  `description` VARCHAR(80)          DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_whitelist_cid_number` (`cid_number`)
);

CREATE TABLE `settings` (
  `id`    INT(11)     NOT NULL AUTO_INCREMENT,
  `name`  VARCHAR(20) NOT NULL,
  `value` VARCHAR(100)         DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_settings_name` (`name`)
);

CREATE TRIGGER ins_cdr_dst BEFORE INSERT ON cdr
  FOR EACH ROW SET NEW.dst = IF(NEW.dst=1234567890,1,NEW.dst);
