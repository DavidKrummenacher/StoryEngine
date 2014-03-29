--
-- Daten für Tabelle `story_pages`
--

INSERT INTO `story_pages` (`id`, `title`, `description`, `content`) VALUES
(1, 'Test', NULL, 'Blah Blah blah'),
(2, 'Test 2', NULL, 'Blah blah 2'),
(3, 'Test 3', NULL, 'Blah blah 3');

--
-- Daten für Tabelle `story_options`
--

INSERT INTO `story_options` (`id`, `source_page`, `order`, `icon`, `text`) VALUES
(1, 1, 1, null, 'Go to page 2'),
(2, 1, 2, null, 'Go to page 3');

--
-- Daten für Tabelle `story_option_targets`
--

INSERT INTO `story_option_targets` (`id`, `option`, `target_page`, `fail`) VALUES
(1, 1, 2, 0),
(2, 2, 3, 0);