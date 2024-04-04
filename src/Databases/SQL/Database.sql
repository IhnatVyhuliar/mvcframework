START TRANSACTION;

CREATE TABLE IF NOT EXISTS `tables` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `table_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `change_action_types` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `changes_history` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `table_uuid` char(64) NOT NULL,
  `target_uuid` char(64) NOT NULL,
  `change_action_type_uuid` char(64) NOT NULL,
  `change` JSON NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `countries` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `name` varchar(64) NOT NULL,
  `iso` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `languages` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `name` varchar(128) NOT NULL,
  `iso` char(2) NOT NULL,
  `country_uuid` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `voivodeships` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `name` varchar(64) NOT NULL,
  `country_uuid` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `cities` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `name` varchar(64) NOT NULL,
  `voivodeship_uuid` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `access_names` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `accesses` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `user_uuid` char(64) NOT NULL,
  `access_name_uuid` char(64) NOT NULL,
  `value` boolean NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS `operative_systems` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `name` varchar(128) NOT NULL,
  `producent` varchar(128) DEFAULT(NULL)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS `devices` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `ipv4` varchar(15) NOT NULL,
  `ipv6` varchar(64) DEFAULT(NULL),
  `country_uuid` char(64) NOT NULL,
  `operative_system_uuid` char(64) NOT NULL,
  `is_verified` boolean DEFAULT(0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS `logins_history` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `user_uuid` char(64) NOT NULL,
  `device_uuid` char(64) NOT NULL,
  `datetime` CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL UNIQUE,
  `gender` boolean NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `phone_number` varchar(17) DEFAULT NULL,
  `city_uuid` char(64) DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `post_iso` varchar(16) NOT NULL,
  `is_email_verified` boolean NOT NULL DEFAULT 0,
  `date_birth` date NOT NULL,
  `password` char(95) NOT NULL,
  `created_account_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `link_types` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `name` varchar(64) NOT NULL,
  `expired_link_time` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `links` (
  `uuid` char(64) PRIMARY KEY NOT NULL UNIQUE,
  `created_by_user_uuid` char(64) DEFAULT(NULL),
  `user_uuid` char(64) NOT NULL,
  `link_type_uuid` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `tags` (
  `uuid` char(64) PRIMARY KEY NOT NULL,
  `name` varchar(60) NOT NULL,
  `user_uuid` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `categories` (
  `uuid` char(64) PRIMARY KEY NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_uuid` char(64)NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `sections` (
  `uuid` char(64) PRIMARY KEY NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `layout` JSON NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `pages` (
  `uuid` char(64) PRIMARY KEY NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category_uuid` char(64) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `user_uuid` char(64) NOT NULL,
  `sections_uuid` char(64) NOT NULL,
  `layout` JSON DEFAULT(NULL)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `changes_history`
  ADD CONSTRAINT `changes_history_table_uuid_foreign` FOREIGN KEY (`table_uuid`) REFERENCES `tables` (`uuid`) ON DELETE CASCADE;

ALTER TABLE `changes_history`
  ADD CONSTRAINT `changes_history_change_action_type_uuid_foreign` FOREIGN KEY (`table_uuid`) REFERENCES `change_action_types` (`uuid`) ON DELETE CASCADE;

ALTER TABLE `users`
  ADD CONSTRAINT `users_city_uuid_foreign` FOREIGN KEY (`city_uuid`) REFERENCES `cities` (`uuid`) ON DELETE CASCADE;

ALTER TABLE `links`
  ADD CONSTRAINT `links_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

ALTER TABLE `links`
  ADD CONSTRAINT `links_link_type_uuid_foreign` FOREIGN KEY (`link_type_uuid`) REFERENCES `link_types` (`uuid`) ON DELETE CASCADE;

ALTER TABLE `tags`
  ADD CONSTRAINT `tags_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

ALTER TABLE `categories`
  ADD CONSTRAINT `categories_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

ALTER TABLE `pages`
  ADD CONSTRAINT `pages_user_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `pages_category_uuid_foreign` FOREIGN KEY (`user_uuid`) REFERENCES `categories` (`uuid`) ON DELETE CASCADE;

ALTER TABLE `languages`
  ADD CONSTRAINT `languages_country_uuid_foreign` FOREIGN KEY (`country_uuid`) REFERENCES `countries` (`uuid`) ON DELETE CASCADE;

ALTER TABLE `voivodeships`
  ADD CONSTRAINT `voivodeships_country_uuid_foreign` FOREIGN KEY (`country_uuid`) REFERENCES `countries` (`uuid`) ON DELETE CASCADE;

ALTER TABLE `cities`
  ADD CONSTRAINT `cities_voivodeship_uuid_foreign` FOREIGN KEY (`voivodeship_uuid`) REFERENCES `voivodeships` (`uuid`) ON DELETE CASCADE;

DELIMITER //

CREATE FUNCTION IF NOT EXISTS GetUUID64() RETURNS CHAR(64)
BEGIN
  DECLARE uuid CHAR(64) DEFAULT "";
  DECLARE uuid_control_sum CHAR(4) DEFAULT "";
  DECLARE i INT DEFAULT 0;
  DECLARE j INT DEFAULT 0;
  DECLARE sum INT DEFAULT 0;
  DECLARE cache INT DEFAULT 0;
  DECLARE first_number INT DEFAULT 0;
  
  WHILE i < 4 DO
    IF (i < 4) THEN
      SET uuid = CONCAT(uuid, "-");
    END IF;

    SET first_number = FLOOR(RAND() * 10);

    IF (first_number = 0) THEN
      SET first_number = first_number + 1;
    END IF;

    SET uuid = CONCAT(uuid, CHAR(48 + first_number));

    WHILE j < 13 DO
      IF (FLOOR(RAND() * 10) < 5) THEN
        SET cache = FLOOR(RAND() * 10);
        SET uuid = CONCAT(uuid, CHAR(48 + cache));
        SET sum = sum + cache;
      ELSE
        SET cache = FLOOR(RAND() * 25);
        SET uuid = CONCAT(uuid, CHAR(65 + cache));
      END IF;

      SET j = j + 1;
    END WHILE;

    SET uuid_control_sum = CONCAT(uuid_control_sum, CHAR(48 + sum % first_number));

    SET j = 0;
    SET i = i + 1;
  END WHILE;

  SET uuid = CONCAT(uuid_control_sum, uuid);
  
  RETURN uuid;
END //

DELIMITER ;
DELIMITER //

CREATE FUNCTION IF NOT EXISTS GetUniqueUUID64(table_name varchar(255)) RETURNS char(64)
BEGIN
  DECLARE existing_count int DEFAULT 0;
  DECLARE unique_uuid char(64) DEFAULT "";

  REPEAT
    SET unique_uuid = GetUUID64();

    CASE table_name
      WHEN 'tables' THEN
        SELECT COUNT(*) INTO existing_count FROM `tables` WHERE uuid = unique_uuid;
      WHEN 'change_action_types' THEN
        SELECT COUNT(*) INTO existing_count FROM `change_action_types` WHERE uuid = unique_uuid;
      WHEN 'changes_history' THEN
        SELECT COUNT(*) INTO existing_count FROM `changes_history` WHERE uuid = unique_uuid;
      WHEN 'languages' THEN
        SELECT COUNT(*) INTO existing_count FROM `languages` WHERE uuid = unique_uuid;
      WHEN 'countries' THEN
        SELECT COUNT(*) INTO existing_count FROM `countries` WHERE uuid = unique_uuid;
      WHEN 'voivodeships' THEN
        SELECT COUNT(*) INTO existing_count FROM `voivodeships` WHERE uuid = unique_uuid;
      WHEN 'cities' THEN
        SELECT COUNT(*) INTO existing_count FROM `cities` WHERE uuid = unique_uuid;
      WHEN 'access_names' THEN
        SELECT COUNT(*) INTO existing_count FROM `access_names` WHERE uuid = unique_uuid;
      WHEN 'accesses' THEN
        SELECT COUNT(*) INTO existing_count FROM `accesses` WHERE uuid = unique_uuid;
      WHEN 'users' THEN
        SELECT COUNT(*) INTO existing_count FROM `users` WHERE uuid = unique_uuid;
      WHEN 'link_types' THEN
        SELECT COUNT(*) INTO existing_count FROM `link_types` WHERE uuid = unique_uuid;
      WHEN 'links' THEN
        SELECT COUNT(*) INTO existing_count FROM `links` WHERE uuid = unique_uuid;
      WHEN 'tags' THEN
        SELECT COUNT(*) INTO existing_count FROM `tags` WHERE uuid = unique_uuid;
      WHEN 'categories' THEN
        SELECT COUNT(*) INTO existing_count FROM `categories` WHERE uuid = unique_uuid;
      WHEN 'sections' THEN
        SELECT COUNT(*) INTO existing_count FROM `sections` WHERE uuid = unique_uuid;
      WHEN 'pages' THEN
        SELECT COUNT(*) INTO existing_count FROM `pages` WHERE uuid = unique_uuid;
      ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Unsupported table name';
    END CASE;
  UNTIL existing_count = 0 END REPEAT;
  
  RETURN unique_uuid;
END //

DELIMITER ;

CREATE TRIGGER IF NOT EXISTS `tables_uuid_trigger` BEFORE INSERT ON `tables` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('tables');
CREATE TRIGGER IF NOT EXISTS `change_action_types_uuid_trigger` BEFORE INSERT ON `change_action_types` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('change_action_types');
CREATE TRIGGER IF NOT EXISTS `changes_history_uuid_trigger` BEFORE INSERT ON `changes_history` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('changes_history');
CREATE TRIGGER IF NOT EXISTS `languages_uuid_trigger` BEFORE INSERT ON `languages` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('languages');
CREATE TRIGGER IF NOT EXISTS `countries_uuid_trigger` BEFORE INSERT ON `countries` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('countries');
CREATE TRIGGER IF NOT EXISTS `voivodeships_uuid_trigger` BEFORE INSERT ON `voivodeships` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('voivodeships');
CREATE TRIGGER IF NOT EXISTS `cities_uuid_trigger` BEFORE INSERT ON `cities` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('cities');
CREATE TRIGGER IF NOT EXISTS `access_names_uuid_trigger` BEFORE INSERT ON `access_names` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('access_names');
CREATE TRIGGER IF NOT EXISTS `accesses_uuid_trigger` BEFORE INSERT ON `accesses` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('accesses');
CREATE TRIGGER IF NOT EXISTS `users_uuid_trigger` BEFORE INSERT ON `users` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('users');
CREATE TRIGGER IF NOT EXISTS `link_types_uuid_trigger` BEFORE INSERT ON `link_types` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('link_types');
CREATE TRIGGER IF NOT EXISTS `links_uuid_trigger` BEFORE INSERT ON `links` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('links');
CREATE TRIGGER IF NOT EXISTS `uuid_trigger` BEFORE INSERT ON `tags` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('tags');
CREATE TRIGGER IF NOT EXISTS `tags_uuid_trigger` BEFORE INSERT ON `categories` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('categories');
CREATE TRIGGER IF NOT EXISTS `sections_uuid_trigger` BEFORE INSERT ON `sections` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('sections');
CREATE TRIGGER IF NOT EXISTS `pages_uuid_trigger` BEFORE INSERT ON `pages` FOR EACH ROW SET NEW.uuid = GetUniqueUUID64('pages');

INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'tables');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'change_action_types');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'changes_history');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'languages');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'countries');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'voivodeships');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'cities');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'access_names');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'accesses');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'users');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'link_types');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'links');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'tags');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'categories');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'sections');
INSERT INTO `tables` (`uuid`, `table_name`) VALUES (NULL, 'pages');

INSERT INTO `countries` (`uuid`, `name`, `iso`) VALUES (NULL, 'Afghanistan', 'AF');

DELIMITER $$

CREATE FUNCTION GetCountryUUID64(country_name varchar(128)) RETURNS char(64)
BEGIN
    SELECT uuid INTO @country_uuid FROM `countries` WHERE name = country_name LIMIT 1;

    RETURN @country_uuid;
END$$

DELIMITER ;

INSERT INTO `languages` (`uuid`, `name`, `iso`, `country_uuid`) VALUES (NULL, 'Pashto', 'ps', GetCountryUUID64('Afghanistan'));

DROP FUNCTION IF EXISTS GetLanguageUUID64;

COMMIT;
