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

//User GitHub data is stored in Session for better performance
if (!isset($_SESSION['github']['user_data']))
{
  $_SESSION['github']['user_data'] = github_api('user');
}


/**
 * Database init
 */

$db_conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);

require 'db.php';


/*** BEGIN SHAMEFUL FUNCTIONS THAT NEED TO BE REFACTORED AND MOVED FROM HERE **/

function github_api($method, $params = array())
{
  if (!isset($_SESSION['github']['access_token']))
  {
    throw new Exception("No GitHub access token is present in session data");
  }
  
  $url = "https://api.github.com/$method?access_token=" . $_SESSION['github']['access_token'];
  $http = http_request($url, $params);
  return json_decode($http->response, true);
}

function http_request($url, $post_fields = null)
{
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
  if (!empty($post_fields))
  {
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_fields));
  }
  
  $response = curl_exec($curl);
  
  return (object) array(
    'response'    => $response,
    'http_status' => curl_getinfo($curl, CURLINFO_HTTP_CODE)
  );
  
  curl_close($curl);
}
