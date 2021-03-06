<?php

//Load config
include 'config.php';

//Load libs
require 'db.php';
require 'misc.php';

/**
 * Session handling
 */

@session_start();

//Init DB
$db_conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
$mysql = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
mysql_select_db(MYSQL_DATABASE, $mysql);

if (basename($_SERVER['SCRIPT_NAME']) != 'gh-login.php' && basename($_SERVER['SCRIPT_NAME']) != 'gh-auth.php')
{
  if (empty($_SESSION['github']['access_token']))
  {
    header("HTTP/1.1 301 Moved Permanently"); //This helps SEO
    header('Location: gh-login.php');
    die;
  }
  
  //User GitHub data is cached in Session for better performance
  if (!isset($_SESSION['github']['user_data']))
  {
    $_SESSION['github']['user_data'] = github_api('user');
  }
}
