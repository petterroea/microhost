-- Hand written sql template
-- Sorry for mistakes
-- - petterroea

CREATE TABLE `apiKeys` (
  `id` int(11) NOT NULL,
  `key` varchar(128) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `apiKeys`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `apiKeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `path` text NOT NULL,
  `hash` varchar(8) NOT NULL,
  `extension` text NOT NULL,
  `filename` text NOT NULL,
  `uploader` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;