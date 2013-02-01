<?php

/**
 * This is the page called back by GitHub oAuth just right after the user 
 * authorized the application. We receive a code that will be used for 
 * requesting the auth token.
 */

include 'init.php';

if (!isset($_GET['code'])) {
  //Page has been called directly or without the required params. Throw error or redirect.
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://github.com/login/oauth/access_token');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
  'client_id'     => GITHUB_CLIENT_ID,
  'client_secret' => GITHUB_CLIENT_SECRET,
  'code'          => $_GET['code']
)));
$result = curl_exec($ch);

$data = array();
parse_str($result, $data);

$_SESSION['github']['access_token'] = $data['access_token'];

if (!empty($_SESSION['github']['access_token'])) {
  header('Location: index.php');
} else {
  /** @todo Handle error */
}
