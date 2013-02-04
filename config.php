<?php

$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'dummy';

define('WEB_ROOT',             "http://$host/");
define('LOCAL_ROOT',           __DIR__ );

define('GITHUB_CLIENT_ID',     getenv('GITHUB_CLIENT_ID'));
define('GITHUB_CLIENT_SECRET', getenv('GITHUB_CLIENT_SECRET'));
define('GITHUB_CALLBACK',      WEB_ROOT . 'gh-auth.php');
define('GITHUB_HOOK_URL',      WEB_ROOT . 'github_webhook.php');

//IP from which web hook must be called
$GITHUB_HOOK_IP = array(
    '207.97.227.253',
    '50.57.128.197',
    '108.171.174.178',
    '50.57.231.61'
);

define('MYSQL_HOST',           getenv('MYSQL_HOST'));
define('MYSQL_USER',           getenv('MYSQL_USER'));
define('MYSQL_PASSWORD',       getenv('MYSQL_PASSWORD'));
define('MYSQL_DATABASE',       getenv('MYSQL_DATABASE'));

define('GA_ID',                 getenv('GA_ID'));