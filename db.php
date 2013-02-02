<?php

/**
 * DML functions
 */

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

function db_select_pending_job()
{
  global $db_conn;
  
  $res = $db_conn->query("SELECT * FROM job JOIN repo ON job.id_repo = repo.id_repo WHERE status = 'waiting' ORDER BY job.created ASC LIMIT 1");
  return $res->fetch_assoc();
  
}

function db_update_job_status($id_job, $status)
{
  global $db_conn;
  
  $stmt = $db_conn->prepare('UPDATE job SET status = ?, UPDATED = 0 WHERE id_job = ?');
  $stmt->bind_param('si', $status, $id_job);
  $stmt->execute();
  return $stmt->affected_rows;
}

function db_update_repo_status($id_job, $status)
{
  global $db_conn;
  
  $stmt = $db_conn->prepare('UPDATE job SET status = ?, UPDATED = 0 WHERE id_job = ?');
  $stmt->bind_param('si', $status, $id_job);
  $stmt->execute();
  return $stmt->affected_rows;
}
