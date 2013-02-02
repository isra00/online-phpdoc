CREATE TABLE `repo` (
  `id_repo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `service` enum('github') NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `lang` enum('php') DEFAULT NULL,
  `doc_status` enum('waiting','generating','updated','fail') NOT NULL DEFAULT 'waiting',
  `last_changeset` varchar(40) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `secret` char(32) NOT NULL,
  PRIMARY KEY (`id_repo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `job` (
  `id_job` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_repo` int(10) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('waiting','generating','done','fail') NOT NULL DEFAULT 'waiting',
  `changeset` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id_job`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
