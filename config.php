<?php

define('GITHUB_CLIENT_ID', getenv('GITHUB_CLIENT_ID'));
define('GITHUB_CLIENT_SECRET', getenv('GITHUB_CLIENT_SECRET'));
define('GITHUB_CALLBACK', getenv('GITHUB_CALLBACK'));

/** @todo calculate WEB_ROOT automatically */
define('WEB_ROOT', 'http://localhost/pruebas/cloudphpdoc/');
define('LOCAL_ROOT', __DIR__ );

define('MYSQL_HOST', getenv('MYSQL_HOST'));
define('MYSQL_USER', getenv('MYSQL_USER'));
define('MYSQL_PASSWORD', getenv('MYSQL_PASSWORD'));
define('MYSQL_DATABASE', getenv('MYSQL_DATABASE'));
