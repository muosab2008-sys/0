CREATE TABLE IF NOT EXISTS `completed_offers` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `transaction_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `campaign_id` int(11) unsigned NOT NULL DEFAULT '0',
  `campaign_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_country` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `user_ip` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `revenue` decimal(12,4) unsigned NOT NULL DEFAULT '0.0000',
  `reward` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `method` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0 = pending, 1 = complete, 2 = rejected, 3 = chargeback, 4 = proxy',
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) unsigned NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ip_checks` (
  `ip_address` varchar(128) DEFAULT NULL,
  `country_code` varchar(16) DEFAULT NULL,
  `status` smallint(11) unsigned NOT NULL DEFAULT '0' COMMENT '0 = clear, 1 = proxy, 99 = unknown',
  `risk_score` int(11) unsigned NOT NULL DEFAULT '0',
  `time` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `requirement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_required` smallint(1) unsigned NOT NULL DEFAULT '0',
  `reward` decimal(8,2) NOT NULL DEFAULT '0.00',
  `time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `jobs_done` (
  `id` int(11) unsigned NOT NULL,
  `job_id` int(11) unsigned NOT NULL DEFAULT '0',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `requirement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reward` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `status` smallint(3) unsigned NOT NULL DEFAULT '0',
  `time` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `list_countries` (
  `id` int(11) NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `offerwall_config` (
  `config_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `config_value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `ref_commissions` (
  `id` int(11) unsigned NOT NULL,
  `user` int(11) NOT NULL DEFAULT '0',
  `referral` int(11) NOT NULL DEFAULT '0',
  `commission` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `site_config` (
  `config_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `config_value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `account_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `country_id` int(11) unsigned NOT NULL DEFAULT '0',
  `gender` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `reg_time` int(11) unsigned NOT NULL DEFAULT '0',
  `last_activity` int(11) unsigned NOT NULL DEFAULT '0',
  `ref_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref` int(11) unsigned NOT NULL DEFAULT '0',
  `reg_ip` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `log_ip` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `activate` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `rec_hash` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ref_source` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `users_activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `notify_id` int(11) NOT NULL DEFAULT '0',
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `read` smallint(2) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `users_deleted` (
  `id` int(11) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `login` varchar(32) NOT NULL,
  `pass` varchar(32) DEFAULT NULL,
  `sex` int(11) NOT NULL DEFAULT '0',
  `country_id` int(11) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users_proxy` (
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(128) DEFAULT NULL,
  `country_code` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users_recovery` (
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `hash_key` varchar(64) DEFAULT NULL,
  `time` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users_sessions` (
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `hash` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `browser` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_address` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `user_logins` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(128) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `value` int(11) NOT NULL DEFAULT '0',
  `price` decimal(12,8) NOT NULL DEFAULT '0.00000000',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `withdrawals` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `coins` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `amount` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `method_id` int(11) unsigned NOT NULL DEFAULT '0',
  `method_name` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_info` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_address` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0 = waiting, 1 = paid, 2 = rejected, 3 = returned',
  `reason` varchar(256) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `withdraw_methods` (
  `id` int(11) unsigned NOT NULL,
  `method` varchar(256) CHARACTER SET utf8mb4 DEFAULT NULL,
  `info` varchar(256) CHARACTER SET utf8mb4 DEFAULT NULL,
  `minimum` decimal(12,2) unsigned NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `wrong_logins` (
  `ip_address` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `count` int(3) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `completed_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `method` (`method`),
  ADD KEY `survey_id` (`transaction_id`),
  ADD KEY `status` (`status`);

ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ip_checks`
  ADD UNIQUE KEY `ip_address` (`ip_address`);

ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `jobs_done`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `status` (`status`);

ALTER TABLE `list_countries`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `offerwall_config`
  ADD UNIQUE KEY `config_name` (`config_name`);

ALTER TABLE `ref_commissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`user`,`referral`) USING BTREE;

ALTER TABLE `site_config`
  ADD UNIQUE KEY `config_name` (`config_name`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ref_code` (`ref_code`),
  ADD KEY `disabled` (`disabled`),
  ADD KEY `reg_time` (`reg_time`);

ALTER TABLE `users_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `users_deleted`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users_proxy`
  ADD UNIQUE KEY `user_id` (`user_id`,`ip_address`);

ALTER TABLE `users_recovery`
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `hash_key` (`hash_key`);

ALTER TABLE `users_sessions`
  ADD UNIQUE KEY `uid` (`uid`);

ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

ALTER TABLE `user_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `timestamp` (`time`);

ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wrong_logins`
  ADD UNIQUE KEY `ip_address` (`ip_address`);

ALTER TABLE `completed_offers`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `faq`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;

ALTER TABLE `jobs`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;

ALTER TABLE `jobs_done`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `list_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=221;

ALTER TABLE `ref_commissions`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `users`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `users_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `user_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `user_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `withdrawals`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `withdraw_methods`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;