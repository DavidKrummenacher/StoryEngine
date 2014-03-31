--
-- Daten für Tabelle `story_pages`
--

--
-- Dumping data for table `story_options`
--

INSERT INTO `story_options` (`id`, `source_page`, `order`, `icon`, `text`) VALUES
(1, 1, 1, 1, 'Go to page 2'),
(2, 1, 2, 2, 'Go to page 3'),
(3, 2, 1, 1, 'go to page 4'),
(4, 2, 1, 1, 'go to page 7'),
(5, 3, 1, 1, 'go to page 5'),
(6, 3, 1, 1, 'go to page 6');

--
-- Dumping data for table `story_option_icons`
--

INSERT INTO `story_option_icons` (`id`, `name`, `description`, `desktop_uri`, `mobile_uri`) VALUES
(1, 'default', 'default action', 'img/desktop/action_icons/1.png', 'img/mobile/action_icons/1.png'),
(2, 'test', 'default action', 'img/desktop/action_icons/2.png', 'img/mobile/action_icons/2.png'),
(3, 'Dunga', 'default action test', 'img/desktop/action_icons/3.png', 'img/mobile/action_icons/3.png'),
(4, 'Pada', 'default action test', 'img/desktop/action_icons/4.png', 'img/mobile/action_icons/4.png'),
(5, 'Hold', 'default action ad', 'img/desktop/action_icons/5.png', 'img/mobile/action_icons/5.png'),
(6, 'OPP', 'default asd ad', 'img/desktop/action_icons/6.png', 'img/mobile/action_icons/6.png'),
(7, 'OPP', 'default asd ad', 'img/desktop/action_icons/7.png', 'img/mobile/action_icons/7.png'),
(8, 'OPP', 'default asd ad', 'img/desktop/action_icons/8.png', 'img/mobile/action_icons/8.png'),
(9, 'OPP', 'default asd ad', 'img/desktop/action_icons/9.png', 'img/mobile/action_icons/9.png');

--
-- Dumping data for table `story_option_targets`
--

INSERT INTO `story_option_targets` (`id`, `option`, `target_page`, `fail`) VALUES
(1, 1, 2, 0),
(2, 2, 3, 0),
(3, 3, 4, 0),
(4, 4, 7, 0),
(5, 5, 6, 0),
(6, 6, 1, 0);

--
-- Dumping data for table `story_pages`
--

INSERT INTO `story_pages` (`id`, `title`, `description`, `content`, `image`) VALUES
(1, 'Test', 'dadalu', 'Blah Blah blah', 0),
(2, 'Test 2', 'dudulahlo', 'Blah blah 2', 0),
(3, 'Test 3', 'madamuma', 'Blah blah 3', 0),
(4, 'Ding Dong', 'blahlba', 'Lorem ipsum', 0),
(5, 'Nummer Neinzig', 'Dasda', 'Und hier auch', 0),
(6, 'Zumderun', 'Dabadan', 'Dabedidab', 0),
(7, 'Alhambrabunda', 'Dedolonga', 'Lorem lorem ipsumdum', 0);