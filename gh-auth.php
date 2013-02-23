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

$result = http_req('https://github.com/login/oauth/access_token', array(
  'client_id'     => GITHUB_CLIENT_ID,
  'client_secret' => GITHUB_CLIENT_SECRET,
  'code'          => $_GET['code']
));

$data = array();
parse_str($result->response, $data);

$_SESSION['github']['access_token'] = $data['access_token'];

if (!empty($_SESSION['github']['access_token'])) {
  header('Location: index.php');
} else {
  /** @todo Handle error */
}
