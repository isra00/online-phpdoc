<?php

define('WEB_ROOT',             'http://' . $_SERVER['HTTP_HOST'] . '/');
define('LOCAL_ROOT',           __DIR__ );

define('GITHUB_CLIENT_ID',     getenv('GITHUB_CLIENT_ID'));
define('GITHUB_CLIENT_SECRET', getenv('GITHUB_CLIENT_SECRET'));
define('GITHUB_CALLBACK',      WEB_ROOT . 'gh-auth.php');
define('GITHUB_HOOK_URL',      WEB_ROOT . 'github_webhook.php');

define('MYSQL_HOST',           getenv('MYSQL_HOST'));
define('MYSQL_USER',           getenv('MYSQL_USER'));
define('MYSQL_PASSWORD',       getenv('MYSQL_PASSWORD'));
define('MYSQL_DATABASE',       getenv('MYSQL_DATABASE'));
