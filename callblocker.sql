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
