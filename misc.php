<?php

/**
 * Miscellaneous functions
 */

/**
 * Simple CURL wrapper
 *
 * @param string $url The URL to request
 * @param array $post_fields POST fields to send
 * @return object The HTTP status code (status) and response (response)
 */
function http_request($url, $post_fields = null, $json_fields = false)
{
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
  if (!empty($post_fields))
  {
    curl_setopt($curl, CURLOPT_POST, true);
    
    $post_data = $json_fields ? json_encode($post_fields) : http_build_query($post_fields);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
  }
  
  $response = curl_exec($curl);
  
  return (object) array(
    'response' => $response,
    'status'   => curl_getinfo($curl, CURLINFO_HTTP_CODE)
  );
  
  curl_close($curl);
}

/**
 * Simple wrapper for RESTful GitHub API v3
 *
 * @param string $method Method to request (REST resource, without leading /)
 * @param array $post_data POST data to be sent in JSON
 * @return array Array-decoded JSON response
 */
function github_api($method, $post_data = array())
{
  if (!isset($_SESSION['github']['access_token']))
  {
    throw new Exception("No GitHub access token is present in session data");
  }
  
  $url = "https://api.github.com/$method?access_token=" . $_SESSION['github']['access_token'];
  $http = http_request($url, $post_data, true);
  
  if ($http->status < 200 || $http->status > 200)
  {
    return false;
  }
  
  return json_decode($http->response, true);
}

/**
 * Simple wrapper for exec()
 *
 * @param string $command The command to be executed
 * @return object An StdClass object command's return_code and output (as array)
 */
function command($command) {
  $return_code = null;
  $output = array();
  exec($command, $output, $return_code);
  
  return (object) array(
    'return_code' => $return_code,
    'output'      => $output
  );
}
