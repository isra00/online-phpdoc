<?php

/**
 * DML functions
 */

function db_search_repo($service, $location)
{
  $res = mysql_query(sprintf("SELECT * FROM repo WHERE service = '%s' AND location = '%s' LIMIT 1",
          mysql_real_escape_string($service),
          mysql_real_escape_string($location)));
  return mysql_fetch_assoc($res);
}

function db_insert_repo($service, $location, $lang, $last_changeset)
{
  //secret is used by GitHub's web hook to authenticate notifications
  $secret = md5(uniqid(true));
  
  $res = mysql_query(sprintf("INSERT INTO repo (service, location, lang, last_changeset, secret) VALUES ('%s', '%s', '%s', '%s', '%s')",
          mysql_real_escape_string($service),
          mysql_real_escape_string($location),
          mysql_real_escape_string($lang),
          mysql_real_escape_string($last_changeset),
          mysql_real_escape_string($secret)));
  
  return array( 
    'id_repo' => mysql_insert_id(),
    'secret' => $secret
  );
}

function db_insert_job($id_repo, $changeset)
{
  $res = mysql_query(sprintf("INSERT INTO job (id_repo, changeset) VALUES ('%d', '%s')",
          mysql_real_escape_string($id_repo),
          mysql_real_escape_string($changeset)));
  return mysql_insert_id();
}

function db_select_pending_job()
{
  $res = mysql_query("SELECT * FROM job JOIN repo ON job.id_repo = repo.id_repo WHERE status = 'waiting' ORDER BY job.created ASC LIMIT 1");
  return mysql_fetch_assoc($res);
}

function db_update_job_status($id_job, $status, $output=null )
{
  mysql_query(sprintf("UPDATE job SET status = '%s', updated = NOW(), output = '%s' WHERE id_job = '%d'",
          mysql_real_escape_string($status),
          mysql_real_escape_string($output),
          mysql_real_escape_string($id_job)));
  return mysql_affected_rows();
}

function db_update_repo_status($id_repo, $status)
{ 
  mysql_query(sprintf("UPDATE repo SET doc_status = '%s', last_update = NOW() WHERE id_repo = '%d'",
          mysql_real_escape_string($status),
          mysql_real_escape_string($id_repo)));
  return mysql_affected_rows();
}

/**
 * Fetch the last 3 successfully generated jobs
 */
function db_get_last_jobs()
{
  $res = mysql_query("SELECT DISTINCT location FROM job
                              JOIN repo ON job.id_repo = repo.id_repo AND repo.doc_status = 'updated' AND repo.service = 'github'
                              ORDER BY job.created DESC
                              LIMIT 3");

  $repos = array();

  while ($row = mysql_fetch_assoc($res))
  {
    $repos[] = $row['location'];
  }

  return $repos;
}

