--
-- Datenbank: `storyengine`
--
CREATE DATABASE IF NOT EXISTS `storyengine` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `storyengine`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `auth_groups`
--

DROP TABLE IF EXISTS `auth_groups`;
CREATE TABLE IF NOT EXISTS `auth_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `auth_login_attempts`
--

DROP TABLE IF EXISTS `auth_login_attempts`;
CREATE TABLE IF NOT EXISTS `auth_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `auth_users`
--

DROP TABLE IF EXISTS `auth_users`;
CREATE TABLE IF NOT EXISTS `auth_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `auth_users`
--

INSERT INTO `auth_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES
(1, '127.0.0.1', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1268889823, 1, 'Admin', 'istrator');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `auth_users_groups`
--

DROP TABLE IF EXISTS `auth_users_groups`;
CREATE TABLE IF NOT EXISTS `auth_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `auth_users_groups`
--

INSERT INTO `auth_users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_achievements`
--

DROP TABLE IF EXISTS `story_achievements`;
CREATE TABLE IF NOT EXISTS `story_achievements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `desktop_uri` varchar(250) DEFAULT NULL,
  `mobile_uri` varchar(250) DEFAULT NULL,
  `attribute` int(11) NOT NULL,
  `comparison` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_attributes`
--

DROP TABLE IF EXISTS `story_attributes`;
CREATE TABLE IF NOT EXISTS `story_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_attribute_comparisons`
--

DROP TABLE IF EXISTS `story_attribute_comparisons`;
CREATE TABLE IF NOT EXISTS `story_attribute_comparisons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(2) NOT NULL,
  `description` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `story_attribute_comparisons`
--

INSERT INTO `story_attribute_comparisons` (`id`, `name`, `description`) VALUES
(1, '==', 'equal to'),
(2, '!=', 'not equal to'),
(3, '>', 'bigger than'),
(4, '>=', 'bigger than or equal to'),
(5, '<', 'smaller than'),
(6, '<=', 'smaller than or equal to');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_attribute_operators`
--

DROP TABLE IF EXISTS `story_attribute_operators`;
CREATE TABLE IF NOT EXISTS `story_attribute_operators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(2) NOT NULL,
  `description` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `story_attribute_operators`
--

INSERT INTO `story_attribute_operators` (`id`, `name`, `description`) VALUES
(1, '+=', 'increment by'),
(2, '-=', 'decrement by'),
(3, '=', 'set to');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_options`
--

DROP TABLE IF EXISTS `story_options`;
CREATE TABLE IF NOT EXISTS `story_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_page` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `icon` int(11) DEFAULT NULL,
  `text` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_option_checks`
--

DROP TABLE IF EXISTS `story_option_checks`;
CREATE TABLE IF NOT EXISTS `story_option_checks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` int(11) NOT NULL,
  `attribute` int(11) NOT NULL,
  `comparison` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `random` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_option_conditions`
--

DROP TABLE IF EXISTS `story_option_conditions`;
CREATE TABLE IF NOT EXISTS `story_option_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` int(11) NOT NULL,
  `attribute` int(11) NOT NULL,
  `comparison` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_option_consequences`
--

DROP TABLE IF EXISTS `story_option_consequences`;
CREATE TABLE IF NOT EXISTS `story_option_consequences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` int(11) NOT NULL,
  `attribute` int(11) NOT NULL,
  `operator` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_option_icons`
--

DROP TABLE IF EXISTS `story_option_icons`;
CREATE TABLE IF NOT EXISTS `story_option_icons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `desktop_uri` varchar(120) DEFAULT NULL,
  `mobile_uri` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_option_targets`
--

DROP TABLE IF EXISTS `story_option_targets`;
CREATE TABLE IF NOT EXISTS `story_option_targets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` int(11) NOT NULL,
  `target_page` int(11) NOT NULL,
  `fail` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_pages`
--

DROP TABLE IF EXISTS `story_pages`;
CREATE TABLE IF NOT EXISTS `story_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `content` text NOT NULL,
  `image` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_page_consequences`
--

DROP TABLE IF EXISTS `story_page_consequences`;
CREATE TABLE IF NOT EXISTS `story_page_consequences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` int(11) NOT NULL,
  `attribute` int(11) NOT NULL,
  `operator` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_page_images`
--

DROP TABLE IF EXISTS `story_page_images`;
CREATE TABLE IF NOT EXISTS `story_page_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `desktop_uri` varchar(250) DEFAULT NULL,
  `mobile_uri` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `story_settings`
--

DROP TABLE IF EXISTS `story_settings`;
CREATE TABLE IF NOT EXISTS `story_settings` (
  `key` varchar(120) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `story_settings`
--

INSERT INTO `story_settings` (`key`, `value`) VALUES
('start_page', 1);
INSERT INTO `story_settings` (`key`, `value`) VALUES
('pages_per_page', 10);

-- --------------------------------------------------------

--
-- Constraints der Tabellen
--

--
-- Constraints der Tabelle `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `auth_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `story_achievements`
--
ALTER TABLE `story_achievements`
  ADD CONSTRAINT `fk_story_achievements_attribute` FOREIGN KEY (`attribute`) REFERENCES `story_attributes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_achievements_comparison` FOREIGN KEY (`comparison`) REFERENCES `story_attribute_comparisons` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `story_options`
--
ALTER TABLE `story_options`
  ADD CONSTRAINT `fk_story_options_page` FOREIGN KEY (`source_page`) REFERENCES `story_pages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_options_icon` FOREIGN KEY (`icon`) REFERENCES `story_option_icons` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `story_option_checks`
--
ALTER TABLE `story_option_checks`
  ADD CONSTRAINT `fk_story_option_checks_option` FOREIGN KEY (`option`) REFERENCES `story_options` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_option_checks_attribute` FOREIGN KEY (`attribute`) REFERENCES `story_attributes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_option_checks_comparison` FOREIGN KEY (`comparison`) REFERENCES `story_attribute_comparisons` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `story_option_conditions`
--
ALTER TABLE `story_option_conditions`
  ADD CONSTRAINT `fk_story_option_conditions_option` FOREIGN KEY (`option`) REFERENCES `story_options` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_option_conditions_attribute` FOREIGN KEY (`attribute`) REFERENCES `story_attributes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_option_conditions_comparison` FOREIGN KEY (`comparison`) REFERENCES `story_attribute_comparisons` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `story_option_consequences`
--
ALTER TABLE `story_option_consequences`
  ADD CONSTRAINT `fk_story_option_consequences_option` FOREIGN KEY (`option`) REFERENCES `story_options` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_option_consequences_attribute` FOREIGN KEY (`attribute`) REFERENCES `story_attributes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_option_consequences_operator` FOREIGN KEY (`operator`) REFERENCES `story_attribute_operators` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `story_option_targets`
--
ALTER TABLE `story_option_targets`
  ADD CONSTRAINT `fk_story_option_targets_option` FOREIGN KEY (`option`) REFERENCES `story_options` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_option_targets_target` FOREIGN KEY (`target_page`) REFERENCES `story_pages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `story_pages`
--
ALTER TABLE `story_pages`
  ADD CONSTRAINT `fk_story_pages_image` FOREIGN KEY (`image`) REFERENCES `story_page_images` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `story_page_consequences`
--
ALTER TABLE `story_page_consequences`
  ADD CONSTRAINT `fk_story_page_consequences_page` FOREIGN KEY (`page`) REFERENCES `story_pages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_page_consequences_attribute` FOREIGN KEY (`attribute`) REFERENCES `story_attributes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_story_page_consequences_operator` FOREIGN KEY (`operator`) REFERENCES `story_attribute_operators` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;