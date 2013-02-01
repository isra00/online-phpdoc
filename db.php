<?php

function db_search_repo($service, $location)
{
  global $db_conn;
  
  $stmt = $db_conn->prepare('SELECT * FROM repo WHERE service = ? AND location = ? LIMIT 1');
  $stmt->bind_param("ss", $service, $location);
  $stmt->execute();
  $res = $stmt->get_result()->num_rows;
  //var_dump($res);
  return $res;
}
