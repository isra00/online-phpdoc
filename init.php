<?php

include 'config.php';

/**
 * Session handling
 */

@session_start();

if ($_SERVER['SCRIPT_NAME'] != 'gh-login.php') {
  if (empty($_SESSION['github']['access_token'])) {
    header('Location: gh-login.php');
    die;
  }
}

//User GitHub data is cached in Session for better performance
if (!isset($_SESSION['github']['user_data']))
{
  $_SESSION['github']['user_data'] = github_api('user');
}

//Init DB
$db_conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);

//Load libs
require 'db.php';
require 'misc.php';
