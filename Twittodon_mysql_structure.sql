SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `connections` (
  `id` int(11) NOT NULL,
  `twitter_login` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `twitter_verified` tinyint(1) NOT NULL,
  `mastodon_login` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `mastodon_verified` tinyint(1) NOT NULL,
  `twitter_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter_img` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `mastodon_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mastodon_img` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `stats_users` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `all_users` int(11) NOT NULL,
  `verified_users` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `stats_views` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

ALTER TABLE `connections`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `stats_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `stats_views`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `stats_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `stats_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;