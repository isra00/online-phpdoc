<?php

include 'config.php';
require 'db.php';
require 'misc.php';

$log = fopen('logs/github_webhook.log', 'a');

function write_log($msg, $die = false)
{
  global $log;

  fwrite($log, '[' . date('Y-m-d H:i:s') . '] ' . $_SERVER['REMOTE_ADDR'] . ' ' . $msg . "\n");

  if ($die)
  {
    die;
  }
}

set_error_handler(function($errno, $errstr, $errfile, $errline)
{
  $l = fopen('logs/php-errors.log', 'a');
	fwrite($l, date('H:i:s') . " $errstr $errfile $errline\n");
	fclose($l);
});

$mysql = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
mysql_select_db(MYSQL_DATABASE, $mysql);

$hook_data = json_decode(file_get_contents('php://input'), true);

if (empty($hook_data))
{
  write_log("Invalid input: $raw_post", true);
}

$slices = explode('/', $hook_data['repository']['url']);
$location = $slices[count($slices) - 2] . '/' . $slices[count($slices) - 1];

if (!$db_repo = db_search_repo('github', $location))
{
  write_log("Repo not found $location");
}

//Insert the job in the queue
db_insert_job($db_repo['id_repo'], $hook_data['head_commit']['id']);