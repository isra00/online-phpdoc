<?php

function db_search_repo($service, $location)
{
  global $db_conn;
  
  $stmt = $db_conn->prepare('SELECT * FROM repo WHERE service = ? AND location = ? LIMIT 1');
  $stmt->bind_param('ss', $service, $location);
  $stmt->execute();
  $res = $stmt->get_result();
  return $res;
}

function db_insert_repo($service, $location, $lang, $last_changeset)
{
  global $db_conn;
  
  $stmt = $db_conn->prepare('INSERT INTO repo (service, location, lang, last_changeset) VALUES (?, ?, ?, ?)');
  $stmt->bind_param('ssss', $service, $location, $lang, $last_changeset);
  $stmt->execute();
  return $stmt->insert_id;
}

function db_insert_job($id_repo, $changeset)
{
  global $db_conn;
  
  $stmt = $db_conn->prepare('INSERT INTO job (id_repo, changeset) VALUES (?, ?)');
  $stmt->bind_param('is', $id_repo, $changeset);
  $stmt->execute();
  return $stmt->insert_id;
}
